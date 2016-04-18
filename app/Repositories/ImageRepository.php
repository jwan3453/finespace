<?php
namespace App\Repositories;
use App\Models\Image;
use App\Models\Product;
Use App\Models\AdSlide;
use App\Tool\MessageResult;

use Qiniu\Auth as QiniuAuth;
use Qiniu\Storage\UploadManager;
use Qiniu\Storage\BucketManager;

class ImageRepository implements  ImageRepositoryInterface
{



    private $accessKey = 'aavEmxVT7o3vsFMGKUZbJ1udnoAbucqXPmk3tdRX';
    private $secretKey ='nDQPr1L7pcurdV8_7iLIICNjSME2EmCiokHXTGTX';
    private $bucket = 'opulent-hotel-image';
    private $auth;

    public function __construct( )
    {

        $this->auth = new QiniuAuth( $this->accessKey,  $this->secretKey);

    }

    public function selectAll()
    {
        return Image::all();
    }

    public function find($id)
    {
        return Image::find($id);
    }


    public function findBy($query){

        return Image::where($query);
    }


    public function delete($query)
    {
        return $deletedRows = Image::where($query)->delete();
    }

    public function uploadImage($request)
    {
        $imageObj=null;
        $token = $this->auth->uploadToken($this->bucket);
        $uploadMgr = new UploadManager();
        $jsonResult = new MessageResult();
        $file = $request->file('file');
        $type = 0;//1 为产品 2 为article 3为用户头像
                 // 当isAdSlide 为1的时后, 1 为产品首页幻灯片
        $isAdSlide = 0;
        $associateId = 0;
        if($request->input('productId') != '')
        {
            $type = 1;
            $associateId = $request->input('productId');
        }
        else if($request->input('articleId') != '')
        {
            $type = 2;
            $associateId = $request->input('articleId');
        }else if ($request->input('UserId') != '') {
            $type = 3;
            $associateId = $request->input('UserId');
        }
        else if($request->input('slideType') !='')
        {
            $type = $request->input('slideType');
            $isAdSlide = 1;
        }


        $filename =time().uniqid().'.'.$file->guessExtension();

        list($result,$error) = $uploadMgr->putFile($token, $filename, $file);

        // if ($request->input('UserId') != '') {
        //     $a = $this->resize_image($file->getClientOriginalName(),$file->getRealPath(),80,80,time());
        //     $jsonResult->pic = $a;
        //     return $jsonResult;
        //     dd($a);
        //     list($result,$error) = $uploadMgr->put($token, $filename, $a);
        // }else{
        //     list($result,$error) = $uploadMgr->putFile($token, $filename, $file);
        // }

        //如果error 为空则上传成功
        if($error == null)
        {
            $imageObj = null;

            if($isAdSlide == 0) {

                $newImage = [
                    'type' => $type,
                    'associateId' => $associateId,
                    'key' => $result['key'],
                    'link' => 'http://7xq9bj.com1.z0.glb.clouddn.com/' . $result['key'],
                ];
                $imageObj = Image::create($newImage);

            }
            else{
                $newImage = [
                    'type' => $type,
                    'key' => $result['key'],
                    'link' => 'http://7xq9bj.com1.z0.glb.clouddn.com/' . $result['key'],
                ];
                $imageObj = AdSlide::create($newImage);

            }

            if ($imageObj != null || $imageObj->id > 0) {
                $jsonResult->statusCode = 1;
                $jsonResult->statusMsg = '上传成功';
                $jsonResult->extra = $imageObj;


            } else {
                $jsonResult->statusCode = 2;
                $jsonResult->statusMsg = '插入数据库失败';
                $jsonResult->extra = $imageObj;
            }

        }
        else{
            $jsonResult->statusCode  = 3;
            $jsonResult->statusMsg = '上传云端失败';
            $jsonResult->extra = $result;
        }

        return $jsonResult;
    }

    public function deleteImage($request)
    {
        $imageKey = $request->input('imageKey');
        $jsonResult = new MessageResult();

        $type = 0; //0 为删除储存在image 表里面的图像 1 为删除储存在adslide 表的图像

        if($request->input('slideType'))
        {
            $type = $request->input('slideType');
        }

        if($imageKey != null)
        {
            //初始化BucketManager
            $bucketMgr = new BucketManager($this->auth);

            //删除$bucket 中的文件 $key
            $err = $bucketMgr->delete($this->bucket, $imageKey);


            if($err == null)
            {

                //删除image 表的图片
                if($type == 0) {
                    $deleteImg = Image::where('key', $imageKey)->first();
                    $product = Product::where('thumb', $deleteImg->id)->first();
                    $deleteRow = $deleteImg->delete();

                    //图片删除后是否影响产品封面
                    if ($deleteRow) {
                        $jsonResult->statusCode = 1;
                        $jsonResult->statusMsg = '删除成功';
                        if ($product != null) {
                            //如果删除的图片为产品封面 要重置产品的封面
                            $product->thumb = '';
                            $product->save();
                        }

                    } else {
                        $jsonResult->statusCode = 2;
                        $jsonResult->statusMsg = '删除失败';
                    }
                }

                //删除adslide 表的图像
                else{
                    $deleteImg = Adslide::where('key', $imageKey)->where('type',$type)->first();
                    $deleteRow = $deleteImg->delete();
                    if ($deleteRow) {

                        $jsonResult->statusCode = 1;
                        $jsonResult->statusMsg = '删除成功';

                    } else {
                        $jsonResult->statusCode = 2;
                        $jsonResult->statusMsg = '删除失败';
                    }
                }

            }
            else{
                $jsonResult->statusCode=3;
                $jsonResult->statusMsg='无法从云端删除';
            }
        }
        else{
            $jsonResult->statusCode=4;
            $jsonResult->statusMsg='图片不存在';
        }
        return $jsonResult;
    }

    public function setImageCover($request)
    {
        $jsonResult = new MessageResult();
        $type = $request->input('type');
        $associateId = $request->input('associateId');
        $imageId = $request->input('imageId');
        if($type == 1)
        {
            $product = Product::find($associateId);
            if($product != null)
            {
                $product->thumb = $imageId;
                $product->save();
                $jsonResult->statusCode=1;
                $jsonResult->statusMessage='更改成功';
            }
        }
        return $jsonResult;
    }

    public function IsUserHeadImage($UserId,$type=3)
    {
        $imgCount = Image::where(['associateId'=>$UserId,'type'=>3])->select('id')->count();

        return $imgCount;
    }

    public function getImageKey($UserId,$type=3)
    {
        $key = Image::where(['associateId'=>$UserId,'type'=>3])->select('key')->first();

        return $key->key;
    }

    public function getUserHeadImg($UserId,$key=3)
    {
        $img = Image::where(['associateId'=>$UserId,'type'=>3])->select('link')->first();
        if ($img) {
            return $img->link;
        }
        else{
            return "/img/icon_member.png";
        }
    }

    //---不要request
    public function deleteImageSingle($imageKey,$slideType='')
    {
        // $imageKey = $request->input('imageKey');

        $jsonResult = new MessageResult();

        $type = 0; //0 为删除储存在image 表里面的图像 1 为删除储存在adslide 表的图像

        if($slideType != '')
        {
            $type = $slideType;
        }

        if($imageKey != null)
        {
            //初始化BucketManager
            $bucketMgr = new BucketManager($this->auth);

            //删除$bucket 中的文件 $key
            $err = $bucketMgr->delete($this->bucket, $imageKey);


            if($err == null)
            {

                //删除image 表的图片
                if($type == 0) {
                    $deleteImg = Image::where('key', $imageKey)->first();
                    $product = Product::where('thumb', $deleteImg->id)->first();
                    $deleteRow = $deleteImg->delete();

                    //图片删除后是否影响产品封面
                    if ($deleteRow) {
                        $jsonResult->statusCode = 1;
                        $jsonResult->statusMsg = '删除成功';
                        if ($product != null) {
                            //如果删除的图片为产品封面 要重置产品的封面
                            $product->thumb = '';
                            $product->save();
                        }

                    } else {
                        $jsonResult->statusCode = 2;
                        $jsonResult->statusMsg = '删除失败';
                    }
                }

                //删除adslide 表的图像
                else{
                    $deleteImg = Adslide::where('key', $imageKey)->where('type',$type)->first();
                    $deleteRow = $deleteImg->delete();
                    if ($deleteRow) {

                        $jsonResult->statusCode = 1;
                        $jsonResult->statusMsg = '删除成功';

                    } else {
                        $jsonResult->statusCode = 2;
                        $jsonResult->statusMsg = '删除失败';
                    }
                }

            }
            else{
                $jsonResult->statusCode=3;
                $jsonResult->statusMsg='无法从云端删除';
            }
        }
        else{
            $jsonResult->statusCode=4;
            $jsonResult->statusMsg='图片不存在';
        }
        return $jsonResult;





    }

    function resize_image($filename, $tmpname, $xmax, $ymax,$time)
    {

        $ext = explode(".", $filename);
        $ext = $ext[count($ext)-1];
        if($ext == "jpg" || $ext == "jpeg")
            $im = imagecreatefromjpeg($tmpname);
        elseif($ext == "png")
            $im = imagecreatefrompng($tmpname);
        elseif($ext == "gif")
            $im = imagecreatefromgif($tmpname);
        $x = imagesx($im);
        $y = imagesy($im);
        // if($x <= $xmax && $y <= $ymax){
        //     return $im;
        // }
        if($x >= $y) {
            $newx = $xmax;
            $newy = $newx * $y / $x;
        }
        else {
            $newy = $ymax;
            $newx = $x / $y * $newy;
        }
        $im2 = imagecreatetruecolor($newx, $newy);
        imagecopyresized($im2, $im, 0, 0, 0, 0, floor($newx), floor($newy), $x, $y);

        $paths='C://project/finespace/app/Repositories/upload/';//上传小图路径
    
        $file3 = $paths.$time.".".$ext;
        imagejpeg($im2,$file3);
     
        $fp = fopen($file3,"rb"); 
        // return $im2;
        $buf = addslashes(fread($fp,filesize($file3))); 
        return $buf;


        
    }


}


