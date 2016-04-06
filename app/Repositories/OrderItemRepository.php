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


    public function save($obj)
    {

    }




}


