<?php
namespace App\Repositories;

use App\Models\ShoppingCart;


class ShoppingCartRepository implements  ShoppingCartRepositoryInterface{

    public function selectAll()
    {
        return ShoppingCart::all();
    }

    public function find($id)
    {
        return ShoppingCart::find($id);
    }


    public function findBy($query,$value){

        return ShoppingCart::where($query,$value)->get();
    }

    public function deleteBy($query,$value){

        return ShoppingCart::where($query,$value)->delete();
    }


    public function save($obj)
    {

        $newItem = new ShoppingCart();
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


