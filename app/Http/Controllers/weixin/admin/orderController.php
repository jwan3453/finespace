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

        return view('admin.weixinAdmin.order.manageOrder')->with('orders',$orders)->with('totalAmount',$totalAmount);
    }

    public function orderDetail($orderNo){

        $orderDetail['order'] = $this->order->findBy(
                                                        [
                                                            [
                                                                'key' => 'order_no',
                                                                'compare'=>'=',
                                                                'value'=>trim($orderNo)
                                                            ]
                                                        ])->first();
        $orderItemArray = array();

        if($orderDetail['order']!=null)
        {


            $orderItems =  $this->orderItem->findBy(['order_id'=>$orderDetail['order']->id]);


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
                else{
                    //找到商品的缩略图
                    //todo 附属商品的照片怎么办
                    if($orderValue->product->thumb != null)
                    {

                        $orderValue->product->thumb =$this->image->find($orderValue->product->thumb)->link;
                    }
                    else{
                        $orderValue->product->thumb = $this->image->findBy(['type'=>1, 'associateId'=>$orderValue->product->id])->first()->link;
                    }
                }
            }

        }
        else
        {

        }
        $orderDetail['orderItems'] = $orderItemArray;

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
}
