<?php
namespace App\Repositories;
use App\Models\OrderItem;



class OrderItemRepository implements  OrderItemRepositoryInterface{

    public function selectAll()
    {
        return OrderItem::all();
    }

    public function find($id)
    {
        return OrderItem::find($id);
    }


    public function findBy($query){

        return OrderItem::where($query)->get();
    }
    public function save($obj)
    {
        $newOrderItem = new OrderItem();
        $newOrderItem->order_id = $obj['order_id'];
        $newOrderItem->product_id = $obj['product_id'];
        $newOrderItem->parent_product_id = $obj['parent_product_id'];
        $newOrderItem->count = $obj['count'];
        $newOrderItem->product_detail = $obj['product_detail'];
        $newOrderItem->save();
        return $newOrderItem;
    }


}


