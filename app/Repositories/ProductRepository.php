<?php
namespace App\Repositories;
use App\Models\Product;
use App\Models\Image;
use App\Models\SpecInfo;
use App\Models\ProductSpec;


class ProductRepository implements  ProductRepositoryInterface{

    public function selectAll($paginate = 0)
    {
        if($paginate!=0)
            return Product::paginate($paginate);
        else

            return Product::all();
    }

    public function find($id)
    {
        return Product::find($id);
    }

//
//    public function findBy($query){
//
//        return Product::where($query)->get();
//    }
    public function save($obj){


//        $newProduct = new Product();
//        $newProduct->category_id = $obj['category_id'];
//        $newProduct->brand_id = $obj['brand_id'];
//        $newProduct->sku = $obj['sku'];
//        $newProduct->name = $obj['name'];
//        $newProduct->inventory = $obj['inventory'];
//        $newProduct->stock_alarm = $obj['stock_alarm'];
//        $newProduct->price = $obj['price'];
//        $newProduct->promote_price = $obj['promote_price'];
//        $newProduct->promote_start_date = $obj['promote_start_date'];
//        $newProduct->promote_end_date = $obj['promote_end_date'];
//        $newProduct->keywords = $obj['keywords'];
//        $newProduct->brief = $obj['brief'];
//        $newProduct->desc = $obj['desc'];
//        $newProduct->status = $obj['status'];
//        $newProduct->is_promote = $obj['is_promote'];
//
//         $newProduct->save();
//        return $newProduct;

    }

    public function update($obj)
    {

//        $newProduct = Product::find($obj['id']);
//        $newProduct->category_id = $obj['category_id'];
//        $newProduct->brand_id = $obj['brand_id'];
//        $newProduct->sku = $obj['sku'];
//        $newProduct->name = $obj['name'];
//        $newProduct->inventory = $obj['inventory'];
//        $newProduct->stock_alarm = $obj['stock_alarm'];
//        $newProduct->price = $obj['price'];
//        $newProduct->promote_price = $obj['promote_price'];
//        $newProduct->promote_start_date = $obj['promote_start_date'];
//        $newProduct->promote_end_date = $obj['promote_end_date'];
//        $newProduct->keywords = $obj['keywords'];
//        $newProduct->brief = $obj['brief'];
//        $newProduct->desc = $obj['desc'];
//        $newProduct->status = $obj['status'];
//        $newProduct->is_promote = $obj['is_promote'];
//
//        $newProduct->save();
//        return $newProduct;
    }




    public function getProductDetail($productId)
    {

        $prod = Product::find($productId);

        $imageLinks=array();
        $specInfos = array();


        if($prod != null)
        {
            //获得图片的缩略图
            $images= Image::where('type',1)->where('associateId',$productId)->get();
            foreach($images  as $image)
            {
                $imageLinks[] = $image->link;
            }
            $prod->img = $imageLinks;



            //获得商品属性列表

            $specs = $prod->specifications()->get();

            foreach( $specs as $spec)
            {
                $specArray=array();
                $specInfo = $spec->specInfo()->get()->first();
                $specArray['content']['name'] =$specInfo->name;
                $specArray['content']['value'] =$spec->value;
                $specArray['level'] =$specInfo->spec_level;
                $specInfos[] = $specArray;
            }
            $prod->spec = $specInfos;


           return $prod;
        }
        else
            return null;
    }


    public function addProduct( $request)
    {

        $newProductArray = $this->setProduct($request);
        return Product::create($newProductArray);
    }

    public function updateProduct($request)
    {
        $product =  Product::find( $request->input('productId'));
        $newProductArray = $this->setProduct($request);
        return $product->update($newProductArray);
    }

    public  function setProduct($request)
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




    public function newProductSpecs($productId)
    {
        $categoryId = 0;
        $product = Product::find($productId);
        if($product!=null)
            $categoryId = $product->category_id;

        $specs = $this->loadSpecs($categoryId);
        $productSpecs = ProductSpec::where('product_id',$productId)->select('spec_info_id','value')->get();

        if(count($productSpecs) != 0)
            return 1;
        return $specs;
    }

    public function addProductSpecs($request)
    {
        $productId= $request->input('productId');

        $specArray = $request->all();
        foreach($specArray as $key=> $spec)
        {
            //如果key 是spec info 的id
            if(is_numeric($key))
            {
                $newSepcs = [
                    'product_id'=>$productId,
                    'spec_info_id'=>$key,
                    'value'=>$spec
                ];
                ProductSpec::create($newSepcs);
            }
        }

    }

    public function editProductSpecs($productId)
    {
//        $categoryId = 0;
//        $product = $this->product->find($productId);
//        if($product != null)
//            $categoryId = $product->category_id;
//
//        $specs = $this->product->loadSpecs($categoryId);

        $productSpecs = ProductSpec::where('product_id',$productId)->select('spec_info_id','value')->get();

            //如果有记录 返回属性列表和属性值让用户更新
            foreach( $productSpecs as $productSpec)
            {
                $specInfo = $productSpec->specInfo()->select('id','name')->first();
                $productSpec->id = $specInfo->id;
                $productSpec->name = $specInfo->name;
            }

        return $productSpecs;
    }

    public function updateProductSpecs($request)
    {

        $productId= $request->input('productId');
        $specs = ProductSpec::where('product_id',$productId)->get();
        $specArray = $request->all();

        foreach($specs as $spec )
        {

            foreach($specArray as $key=> $specInputValue)
            {
                //如果key 是spec info 的id
                if(is_numeric($key) && $spec->spec_info_id == (int)$key )
                {
                    $spec->value = $specInputValue;
                    $spec->save();
                }
            }

        }
    }

    public function loadSpecs($categoryId)
    {
        $specs = SpecInfo::where('category_id',$categoryId)->select('id','name')->get();
        foreach( $specs as $spec)
        {
            $spec->value ='';
        }
        return $specs;
    }
}


