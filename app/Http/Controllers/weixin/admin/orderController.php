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

    public function manageOrder(Request $request)
    {
        $to = $request->input('to');
        $from = $request->input('from');
        $seachData = $request->input('seachData');

        $searchArr = array('to'=>$to,'from'=>$from,'seachData'=>$seachData);
        
        $orders = $this->order->manageOrder($searchArr,5);

        $totalAmount = 0;
        foreach($orders as $order)
        {
            $totalAmount = $totalAmount + $order->total_amount;
        }
        return view('admin.weixinAdmin.order.manageOrder')->with('orders',$orders)->with('totalAmount',$totalAmount)->with('seachData',$seachData)->with('to',$to)->with('from',$from);
    }

    public function orderDetail($orderNo){

        $orderDetail = $this->order->getOrderDetail($orderNo);
        return view('admin.weixinAdmin.order.orderDetail')->with('orderDetail',$orderDetail);
    }

    public function todayOrder(){
      
        $orders  =$this->order->getTodayOrder(4);

        $totalAmount = 0;
        foreach($orders as $order)
        {
            $totalAmount = $totalAmount + $order->total_amount;
        }

        return view('admin.weixinAdmin.order.todayOrder')->with('orders',$orders)->with('totalAmount',$totalAmount)->with('seachData','')->with('to','')->with('from','');

    }

    public function seachOrder(Request $request)
    {
       
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

    public function Statement()
    {
        return view('admin.weixinAdmin.order.Statement');
    }



    public function seachStatementData(Request $request)
    {
        $seachData = $request->input('seachData');

        $orderData = $this->order->seachStatementData($seachData);

        $jsonResult = new MessageResult();
        if ($orderData) {
            $jsonResult=$orderData;
        }else{
            $jsonResult->statusCode = 1;
            $jsonResult->statusMsg = "找不到该订单";
        }

        return response($jsonResult->toJson());
        // dd($orderData);
    }

    public function check_Real_One(Request $request)
    {
        $check = $this->order->check_Real_One($request->input('orderItems_id'));

        $jsonResult = new MessageResult();

        switch ($check) {
            case '1':
                $jsonResult->statusCode = 1;
                $jsonResult->statusMsg = "确认成功！";
                break;

            case '2':
                $jsonResult->statusCode = 0;
                $jsonResult->statusMsg = "该订单已确认！请勿重复确认！";
                break;

            case '3':
                $jsonResult->statusCode = 0;
                $jsonResult->statusMsg = "找不到该信息！";
                break;
            
            default:
                $jsonResult->statusCode = 0;
                $jsonResult->statusMsg = "未知错误！";
                break;
        }

        return response($jsonResult->toJson());
        // dd($check);
    }

    public function check_All_Real(Request $request)
    {
        $All_Real = $this->order->check_All_Real($request->input('order_id'));

        $jsonResult = new MessageResult();

        switch ($All_Real) {
            case '1':
                $jsonResult->statusCode = 1;
                $jsonResult->statusMsg = "确认成功！";
                break;

            case '2':
                $jsonResult->statusCode = 0;
                $jsonResult->statusMsg = "确认失败！请重试！";
                break;

            case '3':
                $jsonResult->statusCode = 0;
                $jsonResult->statusMsg = "找不到该信息！";
                break;
            
            default:
                $jsonResult->statusCode = 0;
                $jsonResult->statusMsg = "未知错误！";
                break;
        }

        return response($jsonResult->toJson());

        // dd($All_Real);
    }

    public function getOrderNotification()
    {

        $orderCount = $this->order->getOrderNotification();

        $jsonResult = new MessageResult();
        $jsonResult->extra=$orderCount;

      return response($jsonResult->toJson());

    }

    public function checkOrder($order_no = '')
    {
        // dd($order_no);
        $orderDetail = $this->order->getOrderDetail($order_no);
        return view('admin.weixinAdmin.order.orderDetailClerk')->with('orderDetail',$orderDetail);
    }


}
