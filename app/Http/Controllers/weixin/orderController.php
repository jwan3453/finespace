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
use Auth;
use Illuminate\Mail\Message;


class orderController extends Controller
{


    private $order;
    private $shoppingCart;
    private $product;
    private $orderItem;

    public function __construct(OrderRepositoryInterface $order,OrderItemRepositoryInterface $orderItem,
                                ShoppingCartRepositoryInterface $shoppingCart, ProductRepositoryInterface $product)
    {
        $this->order = $order;
        $this->orderItem = $orderItem;
        $this->shoppingCart = $shoppingCart;
        $this->product = $product;
    }

    public function orderDetail($orderNo)
    {

        $orderDetail['order'] = $this->order->findBy(['order_no'=>trim($orderNo)])->first();
        $orderItemArray = array();

        if($orderDetail['order']!=null)
        {


            $orderItems =  $this->orderItem->findBy('order_id',$orderDetail['order']->id);


            foreach($orderItems as $key => $orderItem)
            {

                $orderItem->product = $this->product->find($orderItem->product_id);
                //array_push($cartItemsArray, => $cartValue);
                if($orderItem->parent_product_id >0)
                {
                    $orderItemArray[uniqid()] = $orderItem;
                }
                else{
                    $orderItemArray[$orderItem->product_id] = $orderItem;
                }

            }


            foreach($orderItemArray  as  $productId_key =>$orderValue)
            {
                //todo 完善child product 功能
                //判断是否为子商品
                if($orderValue->parent_product_id > 0 )
                {
                    //判断子商品种类
                    if($orderValue->product_id == 2)
                    {
                        //如果父商品存在的话,把子商品添加到父商品中(添加数量即可) 用于view 显示
                        if(isset( $orderItemArray[$orderValue->parent_product_id]))
                            $orderItemArray[$orderValue->parent_product_id]['dinnerWareCount'] = $orderValue->count;
                    }
                    else{
                        if(isset( $orderItemArray[$orderValue->parent_product_id]))
                            $orderItemArray[$orderValue->parent_product_id]['candleCount'] = $orderValue->count;
                    }
                    //添加到父商品后,删除array 的子商品
                    unset($orderItemArray[$productId_key]);
                }

            }

        }
        else
        {

        }
        $orderDetail['orderItems'] = $orderItemArray;
        return view('weixin.order.orderDetail')->with('orderDetail',$orderDetail);
    }

    public function generateOrder(Request $request)
    {

        $payMethod =  $request->input('payMethod');
        $deliveryAddr = $request->input('deliveryAddr');
        $totalPrice = 0.0;
        $jsonResult = new MessageResult();

        if (Auth::check()) {
            $cartItems = $this->shoppingCart->findBy('user_id', Auth::user()->id);

            $newOrderArray = [
                'order_no' => 'E'.time().''.uniqid(),
                'user_id' => Auth::User()->id,
                'address_id'=>$deliveryAddr,
                'recipient_id' => 1,
                'shipping_id' => 1,
                'payment_id' =>$payMethod,
                'delivery_time' =>'2016-03-16:12.12.12',
                'total_amount' =>$totalPrice,
                'shipping_fee' =>0,
                'status' =>0,
                'shipping_status' => 0,
                'pay_status' => 0
            ];
            //保存订单
            $newOrder = $this->order->save($newOrderArray);


            foreach($cartItems as $key=>$cartValue)
            {
                $cartValue->product = $this->product->find($cartValue->product_id);
                if( $cartValue->product !=null)
                {
                    $totalPrice += $cartValue->product->price * $cartValue->count;
                }

                $newOrderItem = [
                    'order_id' => $newOrder->id,
                    'product_id' => $cartValue->product->id,
                    'parent_product_id' => $cartValue->parent_product_id,
                    'count' =>$cartValue->count,
                    'product_detail' =>json_encode($cartValue->product)

                ];
                $this->orderItem->save($newOrderItem);
            }

            $newOrder->total_amount = $totalPrice;
            $newOrder->save();

            $jsonResult->statusMsg='订单提交成功';
            $jsonResult->statusCode=0;
            $jsonResult->extra = $newOrder->order_no;
            return response($jsonResult->toJson());

        } else {
            return view('weixin.home');
        }

    }

    public function getAllOrder($paymentStatus=-1){

        if(Auth::check())
        {
            $query=array();
            if($paymentStatus != -1)
                $query['pay_status'] = $paymentStatus;
            $query['user_id'] = Auth::user()->id;
            $orders = $this->order->findBy($query);

            foreach($orders as $order)
            {
                $orderItems =   $this->orderItem->findBy('order_id',$order->id);

                foreach($orderItems as $orderItem)
                {
                    $orderItem->product = $this->product->findBy('id',$orderItem->product_id)->first();
                }

                $order->orderItems = $orderItems;
            }

            return view('weixin.order.showAllorder')->with('orders',$orders);
        }
        return view('auth.login');
    }


    public function updatePaymentMethod(Request $request)
    {

        $jsonResult = new MessageResult();
        $where['order_no']= $request->input('orderNo');
        $update['payment_id'] = $request->input('paymentMethod');
        $query['where'] = $where;
        $query['update'] = $update;
        $jsonResult->statusCode = $this->order->update($query);
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


