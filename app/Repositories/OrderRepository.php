<?php
namespace App\Repositories;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Image;
use App\Models\ShoppingCart;

use Auth;

class OrderRepository implements  OrderRepositoryInterface{

    public function selectAll($paginate = 0)
    {
        if($paginate!=0)
            return Order::paginate($paginate);
        else

        return Order::all();
    }

    public function find($id)
    {
        return Order::find($id);
    }



    public function findBy($query){

        $obj = null;
        $count = 0;

        foreach($query as $q)
        {


            if($count == 0)
            {
             $obj = Order::where($q['key'],$q['compare'],$q['value']);

            }
            else
            {
                $obj->where($q['key'],$q['compare'],$q['value']);

            }
            $count++;
        }

       return $obj;
    }

    public function update($request)
    {
        $where['order_no']= $request->input('orderNo');
        $update['payment_id'] = $request->input('paymentMethod');
        $query['where'] = $where;
        $query['update'] = $update;
        return Order::where($query['where'])->update($query['update']);
    }

//    public function save($obj)
//    {
//
//        $newOrder = new Order();
//        $newOrder->order_no = $obj['order_no'];
//        $newOrder->user_id = $obj['user_id'];
//        $newOrder->address_id = $obj['address_id'];
//        $newOrder->recipient_id = $obj['recipient_id'];
//        $newOrder->shipping_id = $obj['shipping_id'];
//        $newOrder->payment_id = $obj['payment_id'];
//        $newOrder->delivery_time = $obj['delivery_time'];
//        $newOrder->total_amount = $obj['total_amount'];
//        $newOrder->shipping_fee = $obj['shipping_fee'];
//        $newOrder->status = $obj['status'];
//        $newOrder->shipping_status = $obj['shipping_status'];
//        $newOrder->pay_status = $obj['pay_status'];
//        $newOrder->save();
//        return $newOrder;
//
//    }


    public function getOrderDetail($orderNo)
    {

         $order = Order::where('order_no',$orderNo)->first();

        $orderItemArray = array();

        if($order!=null)
        {

            $orderItems =  $order->orderItems()->get();//OrderItem::where('order_id',$orderDetail['order']->id)->get();//->findBy(['order_id'=>$orderDetail['order']->id]);



            //逻辑跟购物车获取cart item array 一样
            $orderItemArray = (new ShoppingCartRepository())->setCartItemArray($orderItems,$orderItemArray);

        }
        else
        {
            return null;
        }
        $orderDetail['order'] = $order;
        $orderDetail['orderItems'] = $orderItemArray;


        return $orderDetail;
    }

    public function generateOrder( $request)
    {
        $payMethod =  $request->input('payMethod');
        $deliveryAddr = $request->input('deliveryAddr');
        $totalPrice = 0.0;



            $cartItems = ShoppingCart::where('user_id',Auth::user()->id)->get();
            $newOrderArray = [
                'order_no' => 'E' . time() . '' . uniqid(),
                'user_id' => Auth::User()->id,
                'address_id' => $deliveryAddr,
                'recipient_id' => 1,
                'shipping_id' => 1,
                'payment_id' => $payMethod,
                'delivery_time' => '2016-03-16:12.12.12',
                'total_amount' => $totalPrice,
                'shipping_fee' => 0,
                'status' => 0,
                'shipping_status' => 0,
                'pay_status' => 0
            ];
            //保存订单
            $newOrder = Order::create($newOrderArray);


            foreach ($cartItems as $key => $cartValue) {
                $cartValue->product =Product::find($cartValue->product_id);//->find($cartValue->product_id);
                if ($cartValue->product != null) {
                    $totalPrice += $cartValue->product->price * $cartValue->count;
                }

                $newOrderItem = [
                    'order_id' => $newOrder->id,
                    'product_id' => $cartValue->product->id,
                    'parent_product_id' => $cartValue->parent_product_id,
                    'count' => $cartValue->count,
                    'product_detail' => json_encode($cartValue->product)

                ];
                OrderItem::create($newOrderItem);
            }

            $newOrder->total_amount = $totalPrice;
            $newOrder->save();
            return $newOrder;

    }


    public function getAllOrder($paymentStatus)
    {


            $orders = null;
            if($paymentStatus != -1)
            {
                $orders =   Order::where('user_id',Auth::user()->id)->where('pay_status',$paymentStatus)->get();
            }
            else{
                $orders = Order::where('user_id',Auth::user()->id)->get();
            }




            foreach($orders as $order)
            {
                $orderItems =  OrderItem::where('order_id',$order->id);

                foreach($orderItems as $orderItem)
                {
                    $orderItem->product = Product::where('id',$orderItem->product_id)->first();
                }

                $order->orderItems = $orderItems;
            }

            return $orders;


    }

    public function seachOrder($seachData,$paginate)
    {
        if (!empty($paginate)) {
            $orderDetail = Order::where('order_no' , 'like' , "%".$seachData."%")->paginate($paginate);
        }else{
            $orderDetail = Order::where('order_no' , 'like' , "%".$seachData."%")->get();
        }
        
        return $orderDetail;
        
    }
}


?>