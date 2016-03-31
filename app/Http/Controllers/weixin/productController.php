<?php

namespace App\Http\Controllers\weixin;

use App\Models\Category;
use App\Repositories\CategoryRepositoryInterface;
use App\Repositories\ProductRepositoryInterface;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Product;

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

        $prod = $this->product->find($id);
        return view('weixin.product.showProduct')->with('product',$prod);
    }


    public function toCategory()
    {
//        $cat = $this->category->findBy('parent_id', 0);
        return view('weixin.product.category');//->with('categories',$cat);
    }





}
