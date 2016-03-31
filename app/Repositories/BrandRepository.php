<?php
namespace App\Repositories;
use App\Models\Brand;


class BrandRepository implements  BrandRepositoryInterface{

    public function selectAll()
    {
        return Brand::all();
    }

    public function find($id)
    {
        return Brand::find($id);
    }


    public function findBy($query,$value){

        return Brand::where($query,$value)->get();
    }
    public function save(&$obj)
    {

    }

}


