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

        $newProductArray = $this->setProductArray($request);
        $newProduct = $this->product->save($newProductArray);

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
        $newProductArray = $this->setProductArray($request);
        $newProductArray['id'] = $request->input('productId');
        $updatedProduct =  $this->product->update($newProductArray);
        $jsonResult = new MessageResult();
        if($updatedProduct !=null )
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
            $productImages =  $this->productImage->findBy(['associateId'=>$productId]);

            return view('admin.weixinAdmin.product.addProductImages')->with('images',$productImages)
                ->with('productThumbID',$product->thumb)
                ->with('productId',$productId);
        }
        else{
            return '商品不存在';
        }


    }


    public function setProductArray(Request $request)
    {
        $catId = $request->input('selectCat');
        $brandId = $request->input('selectBrand');
        $sku = $request->input('sku');
        $name = $request->input('name');
        $inventory = $request->input('inventory');
        $stockAlarm = $request->input('stockAlarm');
        $price = $request->input('price');
        $promotePrice = $request->input('promotePrice');
        $promoteStartDate = $request->input('promoteStartDate');
        $promoteEndDate = $request->input('promoteEndDate');
        $keyWords = $request->input('keyWords');
        $brief = $request->input('brief');
        $desc = $request->input('desc');
        $status= $request->input('status');
        $promoteStatus = $request->input('promoteStatus');
        if($status == 'on')
        {
            $status = 1;
        }
        else{
            $status = 0;
        }

        if($promoteStatus == 'on')
        {
            $promoteStatus = 1;
        }
        else{
            $promoteStatus = 0;
        }

        $newProductArray= [
            'category_id' => $catId,
            'brand_id'=>$brandId,
            'sku'=> $sku,
            'name'=> $name,
            'inventory' =>$inventory,
            'stock_alarm'=> $stockAlarm,
            'price' => $price,
            'promote_price' =>$promotePrice,
            'promote_start_date' =>$promoteStartDate,
            'promote_end_date' =>$promoteEndDate,
            'keywords' =>$keyWords,
            'brief' =>$brief,
            'desc' =>$desc,
            'status' =>$status,
            'is_promote' =>$promoteStatus,
        ];
        return $newProductArray;
    }



}
