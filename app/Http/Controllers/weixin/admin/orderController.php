<?php

namespace App\Http\Controllers\weixin\admin;


use App\Models\Product;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\OrderRepositoryInterface;
use App\Repositories\OrderItemRepositoryInterface;
use App\Repositories\ProductRepositoryInterface;
use App\Repositories\ImageRepositoryInterface;
use App\Tool\MessageResult;


class orderController extends Controller
{
    //

    private $order;
    private $orderItem;
    private $product;
    private $image;

    public function __construct(OrderRepositoryInterface $order,OrderItemRepositoryInterface $orderItem,
                                ProductRepositoryInterface $product,ImageRepositoryInterface $image)
    {
        $this->order =$order;
        $this->orderItem = $orderItem;
        $this->product = $product;
        $this->image =$image;
    }


    public function index()
    {


    }

    public function manageOrder()
    {
        $orders  =$this->order->selectAll(5);
        $totalAmount = 0;
        foreach($orders as $order)
        {
            $totalAmount = $totalAmount + $order->total_amount;
        }
        return view('admin.weixinAdmin.order.manageOrder')->with('orders',$orders)->with('totalAmount',$totalAmount)->with('seachData','');
    }

    public function orderDetail($orderNo){

        $orderDetail = $this->order->getOrderDetail($orderNo);
        return view('admin.weixinAdmin.order.orderDetail')->with('orderDetail',$orderDetail);
    }

    public function todayOrder(){

        $query = [
            [
                'key' => 'created_at',
                'compare'=>'>',
                'value'=>date('Y-m-d')
            ],
            [
                'key' => 'created_at',
                'compare'=> '<',
                'value'=> date("Y-m-d",strtotime("+1 day"))
            ]
        ];
        $orders  =$this->order->findBy($query)->paginate(4);

        $totalAmount = 0;
        foreach($orders as $order)
        {
            $totalAmount = $totalAmount + $order->total_amount;
        }

        return view('admin.weixinAdmin.order.todayOrder')->with('orders',$orders)->with('totalAmount',$totalAmount);

    }

    public function seachOrder(Request $request)
    {
       // dd($request);
        // dd($request->input());
        $orders = $this->order->seachOrder($request->input(),5);

        $totalAmount = 0;
        foreach($orders as $order)
        {
            $totalAmount = $totalAmount + $order->total_amount;
        }

        return view('admin.weixinAdmin.order.manageOrder')->with('orders',$orders)->with('totalAmount',$totalAmount)->with('seachData',$request->input('seachData'));


    }

    public function seachOrderforGet(Request $request)
    {
        dd($request->input('searchData'));
    }

    public function StockingPage()
    {
        $orders = $this->order->StockingOrder();

        return view('admin.weixinAdmin.order.StockingPage')->with('orders',$orders);
    }
}
