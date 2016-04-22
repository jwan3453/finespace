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
        $cartItemList = $this->shoppingCart->getCartItemsByCookie($cartCookie);


        return view('weixin.cart.showAll')->with('cartItemList',$cartItemList);
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
       // $jsonResult->statusMsg = $cartArray;

        //如果不是ajax 请求
        if($type === 1)
            return  $cartArray;
        //如果是ajax 请求
        else
        {
            if(Auth::check())
            {
                //从数据库中得到购物车数量,然后跟cookie中的商品数量相加
                $existCartItemCount = $this->shoppingCart->getCartItemsCount();
                $jsonResult->statusCode = $productCount += $existCartItemCount;
            }

        }

        return response($jsonResult->toJson());
    }



    public function addToCart(Request $request)
    {
        $jsonResult = new MessageResult();
        $productId = $request->input('productId');


        if($productId =='')
        {
            $jsonResult->statusCode =2;
            $jsonResult->statusMsg = '商品id为空';
            return response($jsonResult->toJson());
        }

        else{
            $addResult =  $this->shoppingCart->addToCart($request);
            $jsonResult->statusCode =1;
//            $jsonResult->statusMsg = $cartArray;
            if($addResult['status'] == 1)
            {
                return response($jsonResult->toJson());
            }
            else if($addResult['status'] == 2)
            {
                return response($jsonResult->toJson())->withCookie('cart',implode(',', $addResult['cartArray'] ));
            }
        }

    }



    public function deleteFromCart(Request $request)
    {
        $jsonResult = new MessageResult();

        $productId = $request->input('productId');

        if($productId =='')
        {
            $jsonResult->statusCode =2;
            $jsonResult->statusMsg = '商品id为空';
            return response($jsonResult->toJson());
        }
        else
        {
            $deleteResult =  $this->shoppingCart->deleteFromCart($request);
            $jsonResult->statusCode =1;
//
            if($deleteResult['status'] == 1)
            {

                return response($jsonResult->toJson());
            }
            else if($deleteResult['status'] == 2)

            {
                $jsonResult->statusMsg = $deleteResult['cartArray'];
                return response($jsonResult->toJson())->withCookie('cart',implode(',', $deleteResult['cartArray'] ));
            }
        }

    }

    private function syncCart($cartArray){


        $cartItemsArray = $this->shoppingCart->syncCart($cartArray);
        return $cartItemsArray;
    }

    public function  updateOrderDateTime( Request $request)
    {
        $JsonResult = new MessageResult();
        if($this->shoppingCart->updateOrderDateTime($request))
        {
            $JsonResult->statusCode = 1;
            $JsonResult->statusMsg = '更新成功';
        }
        else{
            $JsonResult->statusCode = 2;
            $JsonResult->statusMsg = '更新失败';
        }
        return response($JsonResult->toJson());
    }

    public function  updateSelectedStore( Request $request)
    {
        $JsonResult = new MessageResult();
        if($this->shoppingCart->updateSelectedStore($request))
        {
            $JsonResult->statusCode = 1;
            $JsonResult->statusMsg = '更新成功';
        }
        else{
            $JsonResult->statusCode = 2;
            $JsonResult->statusMsg = '更新失败';
        }
        return response($JsonResult->toJson());
    }

}
