<?php
namespace App\Repositories;
use App\Models\Product;


class ProductRepository implements  ProductRepositoryInterface{

    public function selectAll()
    {
        return Product::all();
    }

    public function find($id)
    {
        return Product::find($id);
    }


    public function findBy($query,$value){

        return Product::where($query,$value)->get();
    }


}


