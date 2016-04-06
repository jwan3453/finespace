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




}


