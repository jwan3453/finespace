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
            $cartItems = $this->shoppingCart->findBy('user_id', Auth::user()->id);

            return view('weixin.checkout.checkout');
        } else {
            return view('weixin.home');
        }


    }

}
