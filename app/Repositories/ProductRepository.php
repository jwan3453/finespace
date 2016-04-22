<?php
namespace App\Repositories;
use App\Models\Product;
use App\Models\Image;
use App\Models\SpecInfo;
use App\Models\ProductSpec;
use App\Models\Store;

use App\Tool\MessageResult;


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


            //获得关键字数组

            $keywords=explode('|',$prod->keywords);
            if(count($keywords) == 1)
            {
                if($keywords[0] != '')
                {
                    $prod->keywords = $keywords;
                }
            }
            else{
                $prod->keywords = $keywords;
            }




            //获得商品属性列表

            $specs = $prod->specifications()->get();



            foreach( $specs as $spec)
            {
                $specArray=array();
                $specInfo = $spec->specInfo()->get()->first();

                if($specInfo != null)
                {
                    $specArray['content']['name'] =$specInfo->name;
                    $specArray['content']['value'] =$spec->value;
                    $specArray['level'] =$specInfo->spec_level;
                    $specInfos[] = $specArray;
                }
            }
            $prod->spec = $specInfos;

            //获取门店信息
            $prod->store = Store::select('id','name')->get();

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
        // dd($request);
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
        $is_new = $request->input('is_new');
        $is_hot = $request->input('is_hot');
        $is_recommend = $request->input('is_recommend');
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

        if ($is_new == 'on') {
            $is_new = 1;
        }
        else{
            $is_new = 0;
        }

        if ($is_hot == 'on') {
            $is_hot = 1;
        }else{
            $is_hot = 0;
        }

        if ($is_recommend == 'on') {
            $is_recommend = 1;
        }else{
            $is_recommend = 0;
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
            'is_new' => $is_new,
            'is_hot' => $is_hot,
            'is_recommend' => $is_recommend
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


    //----获取分类下的产品-------
    public function getCategoryProduct($category_id)
    {
        $products = Product::where(['category_id'=>$category_id,'status'=>1])->get();

        foreach ($products as $product) {

            //--获取产品图片---
            $img_link = Image::where('id',$product->thumb)->select('link')->first();

            if ($img_link != null) {
                $product->img = $img_link->link;
            }

            //---操作产品关键词---
            if ($product->keywords != null) {
                $product->words = explode('|', $product->keywords);
            }
        }

        return $products;
    }

    //--修改产品的新品、热销、推荐等状态
    public function changeStatus($productId,$StatusName,$status)
    {
        // $ReturnId = '';
        // $removeClass = '';
        // $addClass = '';
        switch ($StatusName) {
            case 'new':
                if ($status == 0) {
                    Product::where('id',$productId)->update(['is_new'=>1]);
                    $ReturnId = "new_R_".$productId;
                    
                    $changeStatus = 1;
                }elseif ($status == 1) {
                    Product::where('id',$productId)->update(['is_new'=>0]);
                    $ReturnId = "new_C_".$productId;
                  
                    $changeStatus = 2;
                }
                break;
            case 'hot':
                if ($status == 0) {
                    Product::where('id',$productId)->update(['is_hot'=>1]);
                    $ReturnId = "hot_R_".$productId;
                    
                    $changeStatus = 1;
                }elseif ($status == 1) {
                    Product::where('id',$productId)->update(['is_hot'=>0]);
                    $ReturnId = "hot_C_".$productId;
                  
                    $changeStatus = 2;
                }
                break;
            case 'recommend':
                if ($status == 0) {
                    Product::where('id',$productId)->update(['is_recommend'=>1]);
                    $ReturnId = "recommend_R_".$productId;
              
                    $changeStatus = 1;
                }elseif ($status == 1) {
                    Product::where('id',$productId)->update(['is_recommend'=>0]);
                    $ReturnId = "recommend_C_".$productId;
             
                    $changeStatus = 2;
                }
                break;
        }

        $jsonResult = new MessageResult();

        $jsonResult->ReturnId=$ReturnId;
     
        $jsonResult->changeStatus = $changeStatus;
        
        return $jsonResult;
    }


    public function getHotProduct()
    {

//        $Product = Product::where('is_hot',1)->get();
//
//
//        $i = 0;
//        $k = 1;
//
//        //---每三组给一个标记 i
//        foreach ($Product as $product) {
//
//            $product->i = $i;
//
//            $img_link = Image::where('id',$product->thumb)->select('link')->first();
//
//            if ($img_link != null) {
//                $product->img = $img_link->link;
//            }
//
//            if ($k % 3 == 0) {
//
//                $i++;
//            }
//
//            $k++;
//        }
//
//        //--groupBy方法通过给定键分组集合数据项
//        $HotProduct = $Product->groupBy('i');
//
//        // dd($HotProduct);
//        return $HotProduct;
        $products = Product::where('is_hot',1)->take(3)->get();
        foreach ($products as $product) {
            $img_link = Image::where('id',$product->thumb)->select('link')->first();

            if ($img_link != null) {
                $product->img = $img_link->link;
            }
        }
        return  $products;
    }



    public function getRecomProduct()
    {
        $products = Product::where('is_recommend',1)->take(4)->get();
        foreach ($products as $product) {
            $img_link = Image::where('id',$product->thumb)->select('link')->first();

            if ($img_link != null) {
                $product->img = $img_link->link;
            }
        }
        return  $products;
    }

    public function getNewProduct()
    {
        $products = Product::where('is_new',1)->take(3)->get();
        foreach ($products as $product) {
            $img_link = Image::where('id',$product->thumb)->select('link')->first();

            if ($img_link != null) {
                $product->img = $img_link->link;
            }
        }
        return  $products;
    }

    public function searchProduct($searchArr,$paginate = 0)
    {
        switch ($searchArr['jxrc']) {
            case '1'://推荐
                $p = 'is_recommend';
                $d = '1';
                break;
            case '2'://新品
                $p = 'is_new';
                $d = '1';
                break;
            case '3'://热销
                $p = 'is_hot';
                $d = '1';
                break;
            case '4'://促销
                $p = 'is_promote';
                $d = '1';
                break;
            default:
                $p = 'is_promote';
                $d = '';
                break;
            
        }

       
        switch ($searchArr['status']) {
            case '1':
                $status = 'status';
                $statusD = '1';
                break;

            case '2':
                $status = 'status';
                $statusD = '0';
                break;
            
            default:
                $status = 'status';
                $statusD = '';
                break;
        }

        if ($searchArr['searchData'] == '') {
            $search = 'name';
            $searchData = '';
        }else{
            $search = 'name';
            $searchData = $searchArr['searchData'];
        }

        if ($searchArr['category'] == 0) {
            $categoty = 'category_id';
            $category_id = '';
        }else{
            $categoty = 'category_id';
            $category_id = $searchArr['category'];
        }

        // $query = ['status'=>1,'category'=>$category];
         // $products = Product::where($query)
        $products = Product::where($p,$d)->Where($status,$statusD)->Where($categoty,$category_id)->Where($search,'like',"%".$searchData."%")->paginate($paginate);

        return $products;
    }
}


