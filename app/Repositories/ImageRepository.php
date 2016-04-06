<?php
namespace App\Repositories;
use App\Models\Image;
use App\Models\Product;
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
        $type = 0;//1 为产品 2 为article
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
        }



        $filename =time().uniqid().'.'.$file->guessExtension();
        list($result,$error) = $uploadMgr->putFile($token, $filename, $file);
        //如果error 为空则上传成功
        if($error == null)
        {
            $newImage = [
                'type' => $type,
                'associateId' => $associateId,
                'key' => $result['key'],
                'link' =>'http://7xq9bj.com1.z0.glb.clouddn.com/'. $result['key'],
            ];
            $imageObj = Image::create($newImage);
            if($imageObj != null || $imageObj->id > 0)
            {
                $jsonResult->statusCode  = 1;
                $jsonResult->statusMsg = '上传成功';
                $jsonResult->extra = $imageObj;



            }
            else{
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


        if($imageKey != null)
        {
            //初始化BucketManager
            $bucketMgr = new BucketManager($this->auth);

            //删除$bucket 中的文件 $key
            $err = $bucketMgr->delete($this->bucket, $imageKey);


            if($err == null)
            {
                //图片删除后是否影响产品封面

                $deleteImg=  Image::where('key',$imageKey)->first();
                $product = Product::where('thumb',$deleteImg->id)->first();
                $deleteRow = $deleteImg->delete();

                if($deleteRow)
                {
                    $jsonResult->statusCode=1;
                    $jsonResult->statusMsg='删除成功';
                    if($product!=null)
                    {
                        //如果删除的图片为产品封面 要重置产品的封面
                        $product->thumb = '';
                        $product->save();
                    }

                }
                else{
                    $jsonResult->statusCode=2;
                    $jsonResult->statusMsg='删除失败';
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


}


