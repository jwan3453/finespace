<?php
namespace App\Repositories;
use App\Models\Product;


class ProductRepository implements  ProductRepositoryInterface{

    public function selectAll($paginate = 0)
    {
        if($paginate!=0)
            return Product::paginate($paginate);
        else

            return Product::all();
    }

    public function find($id)
    {
        return Product::find($id);
    }


    public function findBy($query,$value){

        return Product::where($query,$value)->get();
    }
    public function save($obj){


        $newProduct = new Product();
        $newProduct->category_id = $obj['category_id'];
        $newProduct->brand_id = $obj['brand_id'];
        $newProduct->sku = $obj['sku'];
        $newProduct->name = $obj['name'];
        $newProduct->inventory = $obj['inventory'];
        $newProduct->stock_alarm = $obj['stock_alarm'];
        $newProduct->price = $obj['price'];
        $newProduct->promote_price = $obj['promote_price'];
        $newProduct->promote_start_date = $obj['promote_start_date'];
        $newProduct->promote_end_date = $obj['promote_end_date'];
        $newProduct->keywords = $obj['keywords'];
        $newProduct->brief = $obj['brief'];
        $newProduct->desc = $obj['desc'];
        $newProduct->status = $obj['status'];
        $newProduct->is_promote = $obj['is_promote'];

         $newProduct->save();
        return $newProduct;

    }

    public function update($obj)
    {

        $newProduct = Product::find($obj['id']);
        $newProduct->category_id = $obj['category_id'];
        $newProduct->brand_id = $obj['brand_id'];
        $newProduct->sku = $obj['sku'];
        $newProduct->name = $obj['name'];
        $newProduct->inventory = $obj['inventory'];
        $newProduct->stock_alarm = $obj['stock_alarm'];
        $newProduct->price = $obj['price'];
        $newProduct->promote_price = $obj['promote_price'];
        $newProduct->promote_start_date = $obj['promote_start_date'];
        $newProduct->promote_end_date = $obj['promote_end_date'];
        $newProduct->keywords = $obj['keywords'];
        $newProduct->brief = $obj['brief'];
        $newProduct->desc = $obj['desc'];
        $newProduct->status = $obj['status'];
        $newProduct->is_promote = $obj['is_promote'];

        $newProduct->save();
        return $newProduct;
    }

}


