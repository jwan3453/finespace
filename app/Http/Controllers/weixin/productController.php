<?php

namespace App\Http\Controllers\weixin;

use App\Tool\MessageResult;
use App\Repositories\CategoryRepositoryInterface;
use App\Repositories\ProductRepositoryInterface;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;



class productController extends Controller
{
    //
    private $category;
    private $product;

    public function __construct(CategoryRepositoryInterface $category, ProductRepositoryInterface $product)
    {
        $this->category = $category;
        $this->product = $product;
    }

    public function showProduct($id)
    {
        $prodDetail = $this->product->getProductDetail($id);
        if($prodDetail != null)
        {
            return view('weixin.product.showProduct')->with('product',$prodDetail);
        }
        return  view('errors.itemNotFound')->with('message','商品没找找到');
    }

    public function toCategory()
    {
//        $cat = $this->category->findBy('parent_id', 0);
        return view('weixin.product.category');//->with('categories',$cat);
    }

    public function CateProList($id)
    {
        $product = $this->product->getCategoryProduct($id);
        return view('weixin.product.CateProList')->with('product',$product['product'])->with('category',$product['category']);
    }

    public function getSellCategory($type)
    {

        $product = $this->product->getSellCategory($type);
        return view('weixin.product.sellCateProds')->with('product',$product)->with('type',$type);
    }

    public function checkProductLimit(Request $request)
    {
        $jsonResult = new MessageResult();
        $result = $this->product->checkProductLimit($request);
        $jsonResult->statusCode = 1;
        $jsonResult->extra = $result;
        return response($jsonResult->toJson());

    }




}
