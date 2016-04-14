<?php

namespace App\Http\Controllers\weixin\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\CategoryRepositoryInterface;

use App\Tool\MessageResult;

class categoryController extends Controller
{

    private $category;

    public function __construct(CategoryRepositoryInterface $category)
    {
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
        // dd($category);
        return view('admin.weixinAdmin.category.CategoryList')->with('category',$category);
    }

    public function getCategory()
    {
        $category_name = $this->category->getNameInfo();

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

}
