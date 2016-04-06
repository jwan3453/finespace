<?php
namespace App\Repositories;
use App\Models\Product;
use App\Models\Image;



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
}


