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


}


