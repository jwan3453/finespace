<?php

namespace App\Http\Controllers\weixin;


use App\Repositories\OrderItemRepositoryInterface;
use App\Tool\MessageResult;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\OrderRepositoryInterface;
use App\Repositories\ShoppingCartRepositoryInterface;
use App\Repositories\ProductRepositoryInterface;
use App\Repositories\ImageRepositoryInterface;
use Auth;
use Illuminate\Mail\Message;


class orderController extends Controller
{


    private $order;
    private $shoppingCart;
    private $product;
    private $orderItem;
    private $image;

    public function __construct(OrderRepositoryInterface $order,OrderItemRepositoryInterface $orderItem,
                                ShoppingCartRepositoryInterface $shoppingCart, ProductRepositoryInterface $product,
                                ImageRepositoryInterface $image)
    {
        $this->order = $order;
        $this->orderItem = $orderItem;
        $this->shoppingCart = $shoppingCart;
        $this->product = $product;
        $this->image = $image;
    }

    public function orderDetail($orderNo)
    {

        $orderDetail = $this->order->getOrderDetail($orderNo);
        return view('weixin.order.orderDetail')->with('orderDetail',$orderDetail);
    }

    public function generateOrder(Request $request)
    {

        if(Auth::check()) {
            $newOrder = $this->order->generateOrder($request);

            $jsonResult = new MessageResult();


            if ($newOrder != null) {
                $jsonResult->statusMsg = '订单提交成功';
                $jsonResult->statusCode = 1;
                $jsonResult->extra = $newOrder->order_no;
                return response($jsonResult->toJson());

            }
            else{
                $jsonResult->statusMsg = '订单提交失败';
                $jsonResult->statusCode = 2;

                return response($jsonResult->toJson());
            }
        }
        return view('weixin.home');
    }

    public function getAllOrder($paymentStatus=-1){

        if(Auth::check())
        {
            $orders=  $this->order->getAllOrder($paymentStatus);

            if(count($orders) != 0)
            {
                return view('weixin.order.showAllorder')->with('orders',$orders);
            }
        }
        return view('auth.login');
    }


    public function updatePaymentMethod(Request $request)
    {

        $jsonResult = new MessageResult();
        $jsonResult->statusCode = $this->order->update($request);
        //是否更新成功 返回1说明成功
        if($jsonResult->statusCode == 1)
        {
            $jsonResult->statusMsg='更改成功';
        }
        else{
            $jsonResult->statusMsg='更新失败';
        }
        return response($jsonResult->toJson());
    }
}


