<?php

namespace App\Http\Controllers\weixin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Tool\MessageResult;
use App\Repositories\ProductRepositoryInterface;
use App\Repositories\ShoppingCartRepositoryInterface;
use Auth;
use App\Models\Shopping_Cart;

class cartController extends Controller
{

    private $product;
    private $shoppingCart;
    public function __construct( ProductRepositoryInterface $product,ShoppingCartRepositoryInterface $shoppingCart)
    {
        $this->product = $product;
        $this->shoppingCart = $shoppingCart;
    }
    public function show(Request $request)
    {

        $cartCookie =  $this->getCartCookie($request,1);

        $cartItemList =array();

        //查看用户是否登录,如果登录 同步cookie 和数据库里面的购物车数据
        if (Auth::check()) {
            $cartItems =  $this->syncCart($cartCookie);
            return response()->view('weixin.cart.showAll', ['cartItemList' => $cartItems])->withCookie('cart', null);
        }

        //循环cookie 推送数据到view
        foreach($cartCookie  as $value)
        {
            $index = strpos($value, ':');

            $newItem = new shopping_cart();
            $newItem->product_id = (int)substr($value, 0,$index);
            $newItem->product_sku = '12331231';
            $newItem->count =(int)substr($value, $index+1);
            $newItem->product = $this->product->find($newItem->product_id);

            if($newItem->product != null)
            {
                array_push($cartItemList,$newItem);
            }
        }

        return view('weixin.cart.showAll')->with('cartItemList',$cartItemList);
    }

    public function addToCart(Request $request)
    {
        //重cookie 里面获取product id
        $jsonResult = new MessageResult();
        $jsonResult->statusCode =0;
        $jsonResult->statusMsg = '添加成功';


        $cart = $request->cookie('cart');
        $productId = $request->input('productId');

        //如果商品属于子商品
        $parentProductId = $request->input('parentProductId');

        $cartArray = ($cart!=null ? explode(',', $cart):array());


        //查看用户是否登录
        $exist = false;
        if (Auth::check()) {
            $cartItems = $this->shoppingCart->findBy('user_id', Auth::user()->id);

            foreach ($cartItems as $cartItem) {
                if($cartItem->product_id == $productId && $cartItem->parent_product_id ==$parentProductId) {
                    $cartItem->count ++;
                    $cartItem->save();
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
                    'count' => 1
                ];
                $cartItem = $this->shoppingCart->save($cartItem);
            }
            return $jsonResult->toJson();
        }


        $count =1;
        foreach($cartArray  as &$value)
        {
            $index = strpos($value, ':');
            if(substr($value, 0 , $index) == $productId){
                $count = ((int) substr($value, $index+1) +1);
                $value = $productId.':'.$count;
                break;
            }

        }

        if($count == 1){
            array_push($cartArray,$productId.':'.$count );
        }




        return  response($jsonResult->toJson())->withCookie('cart',implode(',',$cartArray));

    }

    public function getCartCookie(Request $request, $type=0)
    {
        $jsonResult = new MessageResult();
        $cart = $request->cookie('cart');
        $cartArray = ($cart!=null ? explode(',', $cart):array());

        $productCount = 0;
        foreach($cartArray  as &$value)
        {
            $index = strpos($value, ':');
            $productCount  += (int)substr($value, $index+1);

        }

        $jsonResult->statusCode =$productCount;
        $jsonResult->statusMsg = $cartArray;

        if($type === 1)
            return  $cartArray;
        return response($jsonResult->toJson());

    }

    public function deleteCookieProd(Request $request)
    {
        $jsonResult = new MessageResult();
        $productId = $request->input('productId');
        $cartArray =  $this->getCartCookie($request,1);





        if($productId =='')
        {
            $jsonResult->statusCode =1;
            $jsonResult->statusMsg = '商品id为空';
            return response($jsonResult->toJson());
        }
        else{

            if (Auth::check()) {
                $this->shoppingCart->deleteBy('product_id',$productId);
               // $jsonResult->statusMsg = $cartArray;
            }
            else{


                foreach($cartArray  as $key=> $value)
                {
                    $index = strpos($value, ':');

                    if(substr($value, 0 , $index) == $productId){

                        array_splice($cartArray,$key,1);
                    }
                }
                $jsonResult->statusMsg = $cartArray;
            }
            $jsonResult->statusCode =0;

        }
        return response($jsonResult->toJson())->withCookie('cart',implode(',',$cartArray));

    }

    private function syncCart($cartArray){

        $cartItems = $this->shoppingCart->findBy('user_id', Auth::user()->id);
        $cartItemsArray = array();

        $subProductCount = 0;


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
                $cartItem = [
                    'user_id' => Auth::user()->id,
                    'session' => 'testsession',
                    'product_id' => $productId,
                    'product_sku' => 'testSku',
                    'parent_product_id'=>0,
                    'has_child_product'=>0,
                    'count' => $count
                ];

                $cartItem = $this->shoppingCart->save($cartItem);
                $cartItem->product = $this->product->find($productId);


                $cartItemsArray[$cartItem->product_id] = $cartItem;

            }
        }



        foreach($cartItems as $cartValue)
        {

                $cartValue->product = $this->product->find($cartValue->product_id);
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
                        if($cartValue->product_id == 2)
                        {
                            if(isset( $cartItemsArray[$cartValue->parent_product_id]))
                                $cartItemsArray[$cartValue->parent_product_id]['dinnerWareCount'] = $cartValue->count;
                        }
                        else{
                            if(isset( $cartItemsArray[$cartValue->parent_product_id]))
                                $cartItemsArray[$cartValue->parent_product_id]['candleCount'] = $cartValue->count;
                        }
                    unset($cartItemsArray[$productId_key]);
                }

        }

        return $cartItemsArray;
    }
}
