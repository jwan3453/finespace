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
        $cata = $this->category->getCateNameInfo();
        return view('admin.weixinAdmin.product.manageProduct')->with('products',$products)->with('category',$cata);
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
            return redirect('/weixin/admin/product/addProductSpec/'.$newProduct->id);
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

            return view('admin.weixinAdmin.product.manageProductImage')->with('images',$productImages)
                ->with('productThumbID',$product->thumb)
                ->with('productId',$productId)->with('nav','编辑产品图片');
        }
        else{
            return '商品不存在';
        }

    }

//    public function loadSpecs(Request $request)
//    {
//        $jsonResult = new MessageResult();
//        $specs = $this->product->loadSpecs($request);
//        $jsonResult->extra = $specs;
//        return response($jsonResult->toJson());
//    }

    public function newProductSpecs($productId)
    {

        $specs = $this->product->newProductSpecs($productId);
        //todo 如果产品的属性不为空的话跳转到编辑页面
        if(is_numeric($specs))
        {
            return redirect('/weixin/admin/product/editProductSpec/'.$productId);
        }
        return view('admin.weixinAdmin.product.addProductSpecs')->with('specs',$specs)
            ->with('productId',$productId);

    }


    public function  addProductSpecs(Request $request)
    {

        $productId = $request->input('productId');
        $status = $this->product->addProductSpecs($request);

        return redirect('/weixin/admin/product/addImage/'.$productId);
    }

    public function editProductSpecs($productId)
    {
        $productSpecs = $this->product->editProductSpecs($productId);
        //商品没有属性记录 跳转到创建属性页面
        if(count($productSpecs) == 0)
            return redirect('/weixin/admin/product/addProductSpec/'.$productId);

        return view('admin.weixinAdmin.product.editProductSpecs')->with('specs',$productSpecs)
                                                                 ->with('productId',$productId);
    }

    public function updateProductSpecs(Request $request)
    {
        $productId = $request->input('productId');
       $this->product->updateProductSpecs($request);
        return redirect('/weixin/admin/product');
    }

    public function changeStatus(Request $request)
    {
        $productId = $request->input('productId');
        $StatusName = $request->input('StatusName');
        $status = $request->input('status');

        $ResultData = $this->product->changeStatus($productId,$StatusName,$status);
        // dd($ResultData);
        $jsonResult = new MessageResult();

        if(!empty($ResultData))
        {

            $jsonResult->statusId=$ResultData;
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

    public function seachProduct(Request $request)
    {
        
        $category = $request->input('category') ? $request->input('category') : '';
        $jxrc = $request->input('jxrc') ? $request->input('jxrc') : '';
        $status = $request->input('status') ? $request->input('status') : '';
        $searchData = $request->input('searchData') ? $request->input('searchData') : '';

        $searchArr = array('category'=>$category,'jxrc'=>$jxrc,'status'=>$status,'searchData'=>$searchData);
       
        $products  = $this->product->searchProduct($searchArr,6);
        
        $cata = $this->category->getCateNameInfo();
        return view('admin.weixinAdmin.product.manageProduct')->with('products',$products)->with('category',$cata);
    }


    //获取商品排名
    public function productRank(Request $request)
    {
        $orderBy = $request->input('orderBy');
        $categorySelected = $request->input('category');
        $products = $this->product->productRank($orderBy,$categorySelected);
        $categories = $this->category->getAllCategoryInfo();
        return view('admin.weixinAdmin.product.productRank')->with('products', $products)->with('categories',$categories)->with('categorySelected',$categorySelected)->with('orderBy',$orderBy);
    }
}
