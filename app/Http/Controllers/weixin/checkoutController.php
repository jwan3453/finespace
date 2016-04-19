<?php

namespace App\Http\Controllers\weixin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\Repositories\ProductRepositoryInterface;
use App\Repositories\ShoppingCartRepositoryInterface;



class checkoutController extends Controller
{
    //

    private $product;
    private $shoppingCart;
    public function __construct( ProductRepositoryInterface $product,ShoppingCartRepositoryInterface $shoppingCart)
    {
        $this->product = $product;
        $this->shoppingCart = $shoppingCart;
    }

    public function checkout()
    {

        if (Auth::check()) {

            //从数据库获得购物车商品
            $cartItems = $this->shoppingCart->getCartItems();

            if(count($cartItems) == 0)
            {
                return redirect('weixin/cart');
            }
            return view('weixin.checkout.checkout')->with('cartItems',$cartItems);
        } else {
            return redirect('/auth/login');
        }


    }

}
