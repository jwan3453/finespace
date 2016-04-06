<?php

namespace App\Http\Controllers\weixin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Tool\MessageResult;
use App\Repositories\ProductRepositoryInterface;
use App\Repositories\ShoppingCartRepositoryInterface;
use App\Repositories\ImageRepositoryInterface;
use Auth;
use App\Models\ShoppingCart;

class cartController extends Controller
{

    private $product;
    private $shoppingCart;
    private $image;
    public function __construct( ProductRepositoryInterface $product,ShoppingCartRepositoryInterface $shoppingCart,
                                 ImageRepositoryInterface $image)
    {
        $this->product = $product;
        $this->shoppingCart = $shoppingCart;
        $this->image = $image;
    }
    public function show(Request $request)
    {

        $cartCookie =  $this->getCartCookie($request,1);


        //查看用户是否登录
        if (Auth::check()) {

            //如果登录 同步cookie 和数据库里面的购物车数据
            $cartItems =  $this->syncCart($cartCookie);


            return response()->view('weixin.cart.showAll', ['cartItemList' => $cartItems])->withCookie('cart', null);
        }

        //循环cookie 推送数据到view
        $cartItemList = $this->shoppingCart->getCartItems($cartCookie);


        return view('weixin.cart.showAll')->with('cartItemList',$cartItemList);
    }

    public function addToCart(Request $request)
    {
        $jsonResult = new MessageResult();

        $addResult =  $this->shoppingCart->addToCart($request);

        if($addResult['status'] == false)
        {
            $jsonResult->statusCode = 2;
            $jsonResult->statusMsg ='添加失败';
        }
        else{
            $jsonResult->statusCode = 1;
            $jsonResult->statusMsg ='添加成功';
        }


        if(Auth::check())
        {
            return response($jsonResult->toJson());
        }

        return  response($jsonResult->toJson())->withCookie('cart',implode(',',$addResult['cartArray']));

    }

    public function getCartCookie(Request $request, $type=0)
    {
        $jsonResult = new MessageResult();
        if(Auth::check())
        {

        }
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

        //如果不是ajax 请求
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

            //如何是已经登录 直接从数据库删除
            if (Auth::check()) {

                $this->shoppingCart->deleteBy(['user_id'=>Auth::user()->id,'product_id'=>$productId]);
                $childProducts = $this->shoppingCart->findBy(['user_id'=>Auth::user()->id,'parent_product_id'=>$productId])->get();
                if($childProducts!=null)
                {
                    foreach($childProducts as $childProduct)
                    {
                        $childProduct->delete();
                    }
                }
               // $jsonResult->statusMsg = $cartArray;
            }
            //从cookie中删除
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


        $cartItemsArray = $this->shoppingCart->syncCart($cartArray);
        return $cartItemsArray;
    }
}
