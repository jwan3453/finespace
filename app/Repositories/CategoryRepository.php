<?php
namespace App\Repositories;
use App\Models\Category;


class CategoryRepository implements  CategoryRepositoryInterface{

    public function selectAll()
    {
        return Category::all();
    }

    public function find($id)
    {
        return Category::find($id);
    }


    public function findBy($query,$value){

        return Category::where($query,$value)->get();
    }
    public function save(&$obj)
    {

    }

}


