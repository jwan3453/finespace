<?php
namespace App\Repositories;

use App\Models\ShoppingCart;
use App\Models\Product;
use App\Models\Image;
use App\Models\Store;
use App\Models\Category;
use App\Tool\MessageResult;
use Auth;


class ShoppingCartRepository implements  ShoppingCartRepositoryInterface{

    public function selectAll()
    {
        return ShoppingCart::all();
    }

    public function find($id)
    {
        return ShoppingCart::find($id);
    }

//
    public function findBy($query){

        return ShoppingCart::where($query);
    }

    public function deleteBy($query){

        return ShoppingCart::where($query)->delete();
    }


    public function save($obj)
    {



    }

    public function getCartItems()
    {
        //获得购物车商品清单 获得子商品
        $cartItemsArray = array();
        $cartItems = shoppingCart::where('user_id', Auth::user()->id)->get();

        $cartItemsArray = $this->setCartItemArray($cartItems,$cartItemsArray);
        //dd($cartItemsArray);
        return $cartItemsArray;
    }


    public function getCartItemsByCookie($cartCookie)
    {

        //根据cookie 获取相应的product
        $cartItemList =array();

        $totalOrderAmount =  0;
        foreach($cartCookie  as $value)
        {
            $index = strpos($value, ':');

            $newItem = new shoppingCart();
            $newItem->product_id = (int)substr($value, 0,$index);
            $newItem->product_sku = '12331231';
            $newItem->count =(int)substr($value, $index+1);
            $newItem->product = Product::find($newItem->product_id);
            $newItem->totalAmount = $newItem->product->price *  $newItem->count;


            //获取商品封面图片
            if($newItem->product->thumb != null)
            {
                $newItem->product->thumb =Image::find($newItem->product->thumb)->link;
            }
            else{

                $tmpThumb = Image::where('type',1)->where('associateId',$newItem->product->id)->first();
                //todo 改成这种样式
                if($tmpThumb !=null)
                {
                    $newItem->product->thumb = $tmpThumb->link;
                }
            }

            if($newItem->product != null)
            {
                $totalOrderAmount += $newItem->totalAmount;
                array_push($cartItemList,$newItem);
            }


        }

        if($totalOrderAmount != 0)
        $cartItemList['totalOrderAmount'] = $totalOrderAmount;
        return $cartItemList;
    }
    public function syncCart($cartArray)
    {
        //获取数据库中保存的购物车商品
        $cartItems =  ShoppingCart::where('user_id', Auth::user()->id)->get();


        $cartItemsArray = array();

      //  $subProductCount = 0;

        //循环cookie 中的购物车商品记录
        foreach($cartArray as $value) {
            $exist = false;
            $index = strpos($value, ':');
            $productId = substr($value, 0, $index);
            $count = (int)substr($value, $index + 1);

            //比较cookie 的product 和数据库中的购物车表中的product
            foreach ($cartItems as $cartValue) {


                if ($cartValue->product_id == $productId) {
                    //如果购物车cookie 里的商品数量大于数据空中的购物车商品数量
                    if ($cartValue->count < $count) {
                        $cartValue->count =  $cartValue->count + $count;
                        $cartValue->save();
                    }
                    $exist = true;
                    break;
                }
            }

            if ($exist == false) {
                //创建一个新的购物车商品
                $cartItem = [
                    'user_id' => Auth::user()->id,
                    'session' => 'testsession',
                    'product_id' => $productId,
                    'product_sku' => 'testSku',
                    'parent_product_id'=>0,
                    'has_child_product'=>0,
                    'count' => $count
                ];

                $cartItem = ShoppingCart::create($cartItem);
                $cartItem->product = Product::find($productId);
                $cartItemsArray[$cartItem->product_id] = $cartItem;

            }
        }

        $cartItemsArray = $this->setCartItemArray($cartItems,$cartItemsArray);

        return $cartItemsArray;
    }


    public function addToCart($request)
    {
        //重cookie 里面获取product id
        $cart = $request->cookie('cart');
        $productId = $request->input('productId');
        $orderDateTime= $request->input('orderDateTime');
        $selectedStore = $request->input('selectedStore');
        $quantity = 0;
        $addResult['status'] = 0;

        //如果商品属于子商品
        $parentProductId = $request->input('parentProductId');

        $cartArray = ($cart!=null ? explode(',', $cart):array());
        if($request->input('quantity') != null)
        {
            $quantity = (int)$request->input('quantity');

        }
        else
            $quantity = 1;



        //查看用户是否登录
        $exist = false;
        if (Auth::check()) {

            $cartItems = ShoppingCart::where('user_id', Auth::user()->id)->get();

            foreach ($cartItems as $cartItem) {
                if($cartItem->product_id == $productId && $cartItem->parent_product_id ==$parentProductId)
                {
                    $cartItem->count += $quantity;
                    if($cartItem->save())
                    {
                        $addResult['status'] =1;


                    }
                    else{
                        $addResult['status'] = 0;

                    }
                    $exist = true;
                    break;
                }
            }
            if($exist == false) {

                $cartItem = [
                    'user_id' => Auth::user()->id,
                    'session' => 'testsession',
                    'product_id' => $productId,
                    'parent_product_id'=>$parentProductId,
                    'has_child_product'=>0,
                    'product_sku' => 'testSku',
                    'count' => $quantity,
                    'order_dateTime' => $orderDateTime,
                    'selected_store' => $selectedStore
                ];
                $cartItem = ShoppingCart::create($cartItem);
                if($cartItem != null)
                {
                    $addResult['status'] = 1;

                }
            }
            return $addResult;
        }


         $exist = false;
        foreach($cartArray  as &$value)
        {
            $index = strpos($value, ':');
            if(substr($value, 0 , $index) == $productId){
                $quantity = ((int) substr($value, $index+1) +$quantity);
                $value = $productId.':'.$quantity;
                $exist = true;
                break;
            }

        }

        if($exist == false){
            array_push($cartArray,$productId.':'.$quantity );
        }


        $addResult['status']=2;
        $addResult['cartArray'] = $cartArray;
        return $addResult;

    }


    public function deleteFromCart($request)
    {
            $productId = $request->input('productId');
            $parentProductId = $request->input('parentProductId');
            $type = $request->input('type');
            $cart = $request->cookie('cart');
            $cartArray = ($cart!=null ? explode(',', $cart):array());
            $deleteResult['status'] = 0;
            //如何是已经登录 直接从数据库删除
            if (Auth::check()) {

                //删除整个商品包括子商品
                if($type==1) {
                    ShoppingCart::where(['user_id' => Auth::user()->id, 'product_id' => $productId])->delete();
                    $childProducts = ShoppingCart::where(['user_id' => Auth::user()->id, 'parent_product_id' => $productId])->get();
                    if (count($childProducts) != 0) {
                        foreach ($childProducts as $childProduct) {
                            $childProduct->delete();
                        }
                    }
                }
                //删除单个商品
                else if($type == 2)
                {
                    $item = ShoppingCart::where(['user_id' => Auth::user()->id, 'product_id' => $productId])->first();
                    if($item->count>0)
                    {
                        $item->count -= 1;
                        $item->save();
                    }
                }
                $deleteResult['status'] =1;
            }
            //从cookie中删除
            else{


                foreach($cartArray  as $key=> &$value)
                {
                    $index = strpos($value, ':');

                    if(substr($value, 0 , $index) == $productId){

                        if($type == 1)
                        {
                            //从cookie 中移除商品
                            array_splice($cartArray,$key,1);
                        }
                        else if ($type ==2)
                        {
                            //更改cookie中商品数量
                            if((int) substr($value, $index+1) > 0)
                            {
                                $count = ((int) substr($value, $index+1) -1);
                                $value = $productId.':'.$count;

                            }

                        }
                        break;
                    }
                }

                $deleteResult['status'] =2;
                $deleteResult['cartArray'] = $cartArray;
            }


            return $deleteResult;

    }

    public function getCartItemsCount()
    {

        $totalItemCount = 0;
        $cartItems = shoppingCart::where('user_id', Auth::user()->id)->get();
        foreach( $cartItems as $cartItem)
        {
            $totalItemCount += $cartItem->count;
        }
        return $totalItemCount;
    }



    public function setCartItemArray($cartItems,$cartItemsArray)
    {
        //循环 获得cartItemsArray()
        foreach($cartItems as $cartValue)
        {

            $cartValue->product = Product::find($cartValue->product_id);
            //array_push($cartItemsArray, => $cartValue);
            if($cartValue->parent_product_id >0)
            {
                $cartItemsArray[uniqid()] = $cartValue;
            }
            else{
                $cartItemsArray[$cartValue->product_id] = $cartValue;
            }

        }



        foreach($cartItemsArray  as  $productId_key =>$cartValue)
        {

            //todo 完善child product 功能
            if($cartValue->parent_product_id > 0 )
            {


                //id 为2 的是蛋糕餐具
                if($cartValue->product_id == 2)
                {
                    if(isset( $cartItemsArray[$cartValue->parent_product_id]))
                    {
                        $optionProduct['name']=$cartValue->product->name;
                        $optionProduct['price']=$cartValue->product->price;
                        $optionProduct['count']=$cartValue->count;
                        $optionProduct['totalAmount']=$cartValue->count * $cartValue->product->price;


                        $cartItemsArray[$cartValue->parent_product_id][$cartValue->product_id]=$optionProduct;


                    }
                }

                //id 为3 的是蜡烛
                else if($cartValue->product_id == 3){
                    if(isset( $cartItemsArray[$cartValue->parent_product_id]))
                    {
                        $optionProduct['name']=$cartValue->product->name;
                        $optionProduct['price']=$cartValue->product->price;
                        $optionProduct['count']=$cartValue->count;
                        $optionProduct['totalAmount']=$cartValue->count * $cartValue->product->price;


                        $cartItemsArray[$cartValue->parent_product_id][$cartValue->product_id]=$optionProduct;


                    }
                }
                unset($cartItemsArray[$productId_key]);
            }
            else
            {
                //找到商品的缩略图
                //todo 附属商品的照片怎么办
                if($cartValue->product->thumb != null)
                {

                    $cartValue->product->thumb =Image::find($cartValue->product->thumb)->link;
                }
                else{

                    $tmpThumb = Image::where('type',1)->where('associateId',$cartValue->product->id)->first();
                    //todo 改成这种样式
                    if($tmpThumb !=null)
                    {
                        $cartValue->product->thumb = $tmpThumb->link;
                    }
                }
            }

        }

        //商品是否为蛋糕
        $isCake = false;

        //获取商品的总额
        $totalAmount = 0;
        $totalOrderAmount = 0;
        foreach($cartItemsArray as $cartItem) {
            $totalAmount += $cartItem->count * $cartItem->product->price;

            //加上蜡烛的总额
            $totalAmount += $cartItem['2']['totalAmount'];

            //加上餐具的总额
            $totalAmount += $cartItem['3']['totalAmount'];

            $cartItem->totalAmount = $totalAmount;
            $totalOrderAmount += $totalAmount;
            $totalAmount = 0;

            //查看商品的种类
            $category = Category::where('id',$cartItem->product->category_id)->first();
            if($category!= null)
            {
                $cartItem->rootCategory = Category::where('id', $category->parent_id)->first();
                //如果产品是面包的
                if($cartItem->rootCategory !=null && $cartItem->rootCategory->name=='蛋糕')
                {
                    $isCake = true;
                }
            }
        }


        if($totalOrderAmount != 0)
        {
            $cartItemsArray['totalOrderAmount'] = $totalOrderAmount;
            //传入门店信息
            $cartItemsArray['store'] =Store::select('id','name')->get();
        }

        //如果产品中有蛋糕类 那要显示蛋糕的餐具 蜡烛 选项
        if($isCake == true)
        {
            $optionProductList = [];
            $optionProductList['dinnerWare']= Product::where('name','餐具')->first();
            $optionProductList['candle'] = Product::where('name','蜡烛')->first();

            foreach ( $optionProductList as $type => $optionProduct)
            {
                if($optionProduct->thumb != null)
                {

                    $optionProduct->thumb =Image::find($optionProduct->thumb)->link;
                }
                else{

                    $tmpThumb = Image::where('type',1)->where('associateId',$optionProduct->id)->first();
                    //todo 改成这种样式
                    if($tmpThumb !=null)
                    {
                        $optionProduct->thumb = $tmpThumb->link;
                    }
                }
                if($type == 'dinnerWare' )
                {
                    $cartItemsArray['dinnerImageLink'] = $optionProduct->thumb;
                }
                else{
                    $cartItemsArray['candleImageLink'] = $optionProduct->thumb;
                }
            }


        }


        return $cartItemsArray;
    }

    public function  updateOrderDateTime( $request)
    {

        $productId  = $request->input('productId');
        $newOrderDateTime  = $request->input('newOrderDateTime');
        if(Auth::check())
        {
            return  ShoppingCart::where(['user_id'=>Auth::user()->id,
                                 'product_id' => $productId])->update(['order_dateTime'=>$newOrderDateTime]);
        }
        return false;
    }

    public function  updateSelectedStore( $request)
    {

        $productId  = $request->input('productId');
        $newSelectedStore  = $request->input('newSelectedStore');
        if(Auth::check())
        {
            return  ShoppingCart::where(['user_id'=>Auth::user()->id,
                'product_id' => $productId])->update(['selected_store'=>$newSelectedStore]);
        }
        return false;
    }


    public function deleteCartItems($userId)
    {
        return ShoppingCart::where('user_id',$userId )->delete();

    }

}


