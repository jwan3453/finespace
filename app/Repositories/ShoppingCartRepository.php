<?php
namespace App\Repositories;

use App\Models\Shopping_Cart;


class ShoppingCartRepository implements  ShoppingCartRepositoryInterface{

    public function selectAll()
    {
        return Shopping_Cart::all();
    }

    public function find($id)
    {
        return Shopping_Cart::find($id);
    }


    public function findBy($query,$value){

        return Shopping_Cart::where($query,$value)->get();
    }

    public function deleteBy($query,$value){

        return Shopping_Cart::where($query,$value)->delete();
    }


    public function save($obj)
    {

        $newItem = new Shopping_Cart();
        $newItem->user_id = $obj['user_id'];
        $newItem->session = $obj['session'];
        $newItem->product_id = $obj['product_id'];
        $newItem->parent_product_id = $obj['parent_product_id'];
        $newItem->has_child_product = $obj['has_child_product'];
        $newItem->product_sku = $obj['product_sku'];
        $newItem->count = $obj['count'];

        $newItem->save();
        return $newItem;

    }


}


