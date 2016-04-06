<?php

namespace App\Http\Controllers\weixin\admin;


use App\Models\Product;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\ProductRepositoryInterface;
use App\Repositories\CategoryRepositoryInterface;
use App\Repositories\BrandRepositoryInterface;
use App\Repositories\ImageRepositoryInterface;

use App\Tool\MessageResult;


class productController extends Controller
{
    //

    private $product;
    private $category;
    private $brand;

    public function __construct(UserRepositoryInterface $user,ProductRepositoryInterface $product,
                                CategoryRepositoryInterface $category,BrandRepositoryInterface $brand,
                                ImageRepositoryInterface $productImage)
    {
        $this->product = $product;

        $this->category = $category;
        $this->brand = $brand;
        $this->productImage =$productImage;
    }


    public function index()
    {

        return view('admin.weixinAdmin.home');
    }

    public function manageProduct()
    {
        $products  = $this->product->selectAll(6);
        return view('admin.weixinAdmin.product.manageProduct')->with('products',$products);
    }

    public function newProduct()
    {
        $product = new Product();
        $categories = $this->category->selectAll();
        $brands = $this->brand->selectAll();
        return view('admin.weixinAdmin.product.addProduct')->with('product',$product)
                                                           ->with('categories',$categories)
                                                           ->with('brands',$brands);

    }

    public function addProduct(Request $request){

        //$newProductArray = $this->setProductArray($request);
        $newProduct = $this->product->addProduct($request);

        if($newProduct!=null && $newProduct->id >0)
        {
            return redirect('/weixin/admin/product/addImage/'.$newProduct->id);
        }

        return redirect('/weixin/admin/product/add');
    }

    public function editProduct($productId)
    {
        $product = $this->product->find($productId);
        $categories = $this->category->selectAll();
        $brands = $this->brand->selectAll();

        if($product == null)
        {
            //todo 错误页面
            return response('产品不存在');
        }
        return view('admin.weixinAdmin.product.editProduct')->with('product',$product)
            ->with('categories',$categories)
            ->with('brands',$brands);

    }

    public function updateProduct(Request $request)
    {


        $updatedProduct =  $this->product->updateProduct($request);
        $jsonResult = new MessageResult();
        if($updatedProduct)
        {

            $jsonResult->statusCode=1;
            $jsonResult->statusMsg="更新成功";

        }
        else
        {
            //todo
            $jsonResult->statusCode=2;
            $jsonResult->statusMsg="更新失败";
        }
        return response($jsonResult->toJson());
    }


    public function addProductImages($productId)
    {

        $product = $this->product->find($productId);
        if($product !=null)
        {
            $productImages =  $this->productImage->findBy(['type'=>1,'associateId'=>$productId])->get();

            return view('admin.weixinAdmin.product.addProductImages')->with('images',$productImages)
                ->with('productThumbID',$product->thumb)
                ->with('productId',$productId);
        }
        else{
            return '商品不存在';
        }


    }


}
