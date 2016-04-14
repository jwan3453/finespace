<?php
namespace App\Repositories;

use App\Models\ShoppingCart;
use App\Models\Product;
use App\Models\Image;
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
                        $cartItemsArray[$cartValue->parent_product_id]['dinnerWareCount'] = $cartValue->count;
                }
                //id 为3 的是蛋糕蜡烛
                else if($cartValue->product_id == 3){
                    if(isset( $cartItemsArray[$cartValue->parent_product_id]))
                        $cartItemsArray[$cartValue->parent_product_id]['candleCount'] = $cartValue->count;
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
                    $cartValue->product->thumb = Image::where('type',1)->where( 'associateId',$cartValue->product->id)->first()->link;
                }
            }
        }


        return $cartItemsArray;
    }


    public function getCartItemsByCookie($cartCookie)
    {

        //根据cookie 获取相应的product
        $cartItemList =array();
        foreach($cartCookie  as $value)
        {
            $index = strpos($value, ':');

            $newItem = new shoppingCart();
            $newItem->product_id = (int)substr($value, 0,$index);
            $newItem->product_sku = '12331231';
            $newItem->count =(int)substr($value, $index+1);
            $newItem->product = Product::find($newItem->product_id);



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
                array_push($cartItemList,$newItem);
            }

        }
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
                        $cartValue->count = $count;
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
                        $cartItemsArray[$cartValue->parent_product_id]['dinnerWareCount'] = $cartValue->count;
                }

                //id 为3 的是蜡烛
                else if($cartValue->product_id == 3){
                    if(isset( $cartItemsArray[$cartValue->parent_product_id]))
                        $cartItemsArray[$cartValue->parent_product_id]['candleCount'] = $cartValue->count;
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
                    $cartValue->product->thumb = Image::where('type',1)->where( 'associateId',$cartValue->product->id)->first()->link;
                }
            }
        }


        return $cartItemsArray;

    }


    public function addToCart($request)
    {
        //重cookie 里面获取product id




        $cart = $request->cookie('cart');
        $productId = $request->input('productId');
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
                    'count' => $quantity
                ];
                $cartItem = ShoppingCart::create($cartItem);
                if($cartItem != null)
                {
                    $addResult['status'] = 1;

                }
            }
            return $addResult;
        }


        $count =1;
        foreach($cartArray  as &$value)
        {
            $index = strpos($value, ':');
            if(substr($value, 0 , $index) == $productId){
                $count = ((int) substr($value, $index+1) +$quantity);
                $value = $productId.':'.$count;
                break;
            }

        }

        if($count == 1){
            array_push($cartArray,$productId.':'.$count );
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

}


