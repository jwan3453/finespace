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

    public function getAllCategoryInfo()
    {
    	$CategoryInfo = Category::all();

    	foreach ($CategoryInfo as $info) {
    		if ($info->parent_id != 0) {
    			$getname = Category::where("id",$info->parent_id)->select('name')->first();
    			$info->parent_name = $getname->name;
    		}else{
    			$info->parent_name = "首级";
    		}
    	}

    	// dd($CategoryInfo);
    	return $CategoryInfo;
    }

    public function getNameInfo($categoryid)
    {
    	return Category::where('id' , '!=' , $categoryid)->select('id','name')->get();
    	// dd($AllName);
    }

    public function getCateNameInfo()
    {
        return Category::select('id','name')->get();
        // dd($AllName);
    }

    public function updateOraddCategory($request)
    {
    	$name = $request->input('name');
    	$parent_id = $request->input('parent_id');
    	$desc = $request->input('desc');
    	$id = $request->input('categoryid');
    	$editOradd = $request->input('editOradd');

    	$datetime = date('Y-m-d H:i:s',time());

    	if ($editOradd == 'edit') {
    		$isUpdateOrAdd = Category::where('id',$id)->update(['name'=>$name,'desc'=>$desc,'parent_id'=>$parent_id,'updated_at'=>$datetime]);
    	}else if ($editOradd == 'add') {
    		$isUpdateOrAdd = Category::insert([
			    ['name'=>$name,'desc'=>$desc,'parent_id'=>$parent_id,'created_at'=>$datetime,'updated_at'=>$datetime],
			]);
    	}


    	if ($isUpdateOrAdd) {
    		return true;
    	}
    	else{
    		return false;
    	}

    }

    public function DelCategory($id)
    {
    	$isDel = Category::where('id', $id)->delete();

        if ($isDel) {
            return true;
        }else{
            return false;
        }
    }




}


