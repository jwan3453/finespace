<?php

namespace App\Http\Controllers\weixin\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\CategoryRepositoryInterface;
use App\Repositories\SpecInfoRepositoryInterface;

use App\Tool\MessageResult;

class categoryController extends Controller
{

    private $category;
    private $specinfo;

    public function __construct(CategoryRepositoryInterface $category , SpecInfoRepositoryInterface $specinfo)
    {
        $this->specinfo = $specinfo;
        $this->category = $category;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function categoryList()
    {
        $category = $this->category->getAllCategoryInfo();
        
        return view('admin.weixinAdmin.category.CategoryList')->with('category',$category);
    }

    public function getCategory(Request $request)
    {
        $category_name = $this->category->getNameInfo($request->input('categoryid'));

        return $category_name;
    }

    public function updateOraddCategory(Request $request)
    {
        $isUpdate = $this->category->updateOraddCategory($request);
        // dd($request->input('name'));
        $result_msg = $request->input('editOradd') == "add" ? "添加" : "更新";
        $jsonResult = new MessageResult();
        if ($isUpdate) {
            $jsonResult->statusCode=1;
            $jsonResult->statusMsg= $result_msg . "成功";
        }else{
            $jsonResult->statusCode=2;
            $jsonResult->statusMsg= $result_msg . "失败";
        }

        return response($jsonResult->toJson());
    }

    public function del(Request $request)
    {
        $id = $request->input('id');
        $isDel = $this->category->DelCategory($id);

        $jsonResult = new MessageResult();

        if ($isDel) {
            $jsonResult->statusCode=1;
            $jsonResult->statusMsg= "删除成功";
        }else{
            $jsonResult->statusCode=2;
            $jsonResult->statusMsg= "删除失败";
        }

        return response($jsonResult->toJson());
    }

    public function categorySpecList()
    {
        $SpecList = $this->specinfo->getAllInfo(10);
      
        return view('admin.weixinAdmin.category.categorySpecList')->with('SpecList',$SpecList);
        
    }

    public function getAllCategoryNameInfo()
    {
        $categoryList = new MessageResult();
        $categoryList = $this->category->getAllCategoryNameInfo();

        return response($categoryList->toJson());
    }

    public function updateOraddSpecInfo(Request $request)
    {
        $isUpdate = $this->specinfo->updateOraddSpecInfo($request);
        // dd($request->input('name'));
        $result_msg = $request->input('editOradd') == "add" ? "添加" : "更新";
        $jsonResult = new MessageResult();
        if ($isUpdate) {
            $jsonResult->statusCode=1;
            $jsonResult->statusMsg= $result_msg . "成功";
        }else{
            $jsonResult->statusCode=2;
            $jsonResult->statusMsg= $result_msg . "失败";
        }

        return response($jsonResult->toJson());
    }

    public function delSpecInfo(Request $request)
    {
        $id = $request->input('id');
        $isDel = $this->specinfo->delSpecInfo($id);

        $jsonResult = new MessageResult();

        if ($isDel) {
            $jsonResult->statusCode=1;
            $jsonResult->statusMsg= "删除成功";
        }else{
            $jsonResult->statusCode=2;
            $jsonResult->statusMsg= "删除失败";
        }

        return response($jsonResult->toJson());
    }

}
