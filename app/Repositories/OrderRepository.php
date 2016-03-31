<?php
namespace App\Repositories;
use App\Models\Order;


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

    public function update($query)
    {
        return Order::where($query['where'])->update($query['update']);
    }

    public function save($obj)
    {

        $newOrder = new Order();
        $newOrder->order_no = $obj['order_no'];
        $newOrder->user_id = $obj['user_id'];
        $newOrder->address_id = $obj['address_id'];
        $newOrder->recipient_id = $obj['recipient_id'];
        $newOrder->shipping_id = $obj['shipping_id'];
        $newOrder->payment_id = $obj['payment_id'];
        $newOrder->delivery_time = $obj['delivery_time'];
        $newOrder->total_amount = $obj['total_amount'];
        $newOrder->shipping_fee = $obj['shipping_fee'];
        $newOrder->status = $obj['status'];
        $newOrder->shipping_status = $obj['shipping_status'];
        $newOrder->pay_status = $obj['pay_status'];
        $newOrder->save();
        return $newOrder;

    }


}


?>