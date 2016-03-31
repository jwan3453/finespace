<?php

namespace App\Http\Controllers\Service;


use Illuminate\Http\Request;

use App\Http\Requests;


use App\Http\Controllers\Controller;

use App\Tool\ValidateCode;
use App\Tool\SendTemplateSMS;
use App\Tool\MessageResult;

use App\Repositories\SmsCodeLogRepositoryInterface;
use App\Repositories\ImageRepositoryInterface;
use App\Repositories\ProductRepositoryInterface;


use Qiniu\Auth as QiniuAuth;
use Qiniu\Storage\UploadManager;
use Qiniu\Storage\BucketManager;


class CommonController extends Controller
{
    //

    private $smsCodeLog;
    private $image;

    private $accessKey = 'aavEmxVT7o3vsFMGKUZbJ1udnoAbucqXPmk3tdRX';
    private $secretKey ='nDQPr1L7pcurdV8_7iLIICNjSME2EmCiokHXTGTX';
    private $bucket = 'opulent-hotel-image';
    private $auth;
    private $product ;

    public function __construct( SmsCodeLogRepositoryInterface $smsCodeLog, ImageRepositoryInterface $image,
                                 ProductRepositoryInterface $product)
    {
        $this->smsCodeLog = $smsCodeLog;
        $this->image = $image;
        $this->auth = new QiniuAuth( $this->accessKey,  $this->secretKey);
        $this->product = $product;
    }



    public function generateSmsCode(){
            return $CheckCode= rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);
        }
        public function createValidateCode(Request $request)
        {
            $validateCode = new ValidateCode;
            $valideImg =  $validateCode->doimg();
            $request->session()->put('validateCode',$validateCode->getCode());


            return $valideImg;


        }

        public function verifyValidateCode(Request $request)
        {
            $jsonResult = new MessageResult();
            $ValidateCode = $request->input('validateCode');


            if(strtolower($ValidateCode) == $request->session()->get('validateCode',''))
            {

                $jsonResult->statusCode = 1;

            }
            else{
                //验证码发送正常
                $jsonResult->statusCode =0;
                $jsonResult->statusMsg = '随机验证码不正确';
            }
            return response($jsonResult->toJson());
        }



        public function sendSmsCode(Request $request)
        {
            $smscode = new sendTemplateSMS;
            $jsonResult = new MessageResult();
            $status = ';';
            $code = $this->generateSmsCode();
            $mobile =$request->input('mobile');
            if($mobile =='')
            {
                $jsonResult->statusCode = 3;
                $jsonResult->statusMsg ='手机号为空';

            }
            else {
                //发送验证码到手机
                $result = $smscode->sendTemplateSMS($mobile, array($code, 2), 1);

                //检查发送状态
                if ($result == null) {

                    $jsonResult->statusCode =2;
                    $jsonResult->statusMsg = '发送失败';

                }
                if ($result->statusCode != 0) {//if($result->statusCode!=0) {

                    //TODO 添加错误处理逻辑
                    $jsonResult->statusCode = 0;
                    $jsonResult->statusMsg= '发送失败' ;
                    $jsonResult->extra =$result;
                } else {

                    //TODO 添加成功处理逻辑
                    //发送成功 代码为1
                    $jsonResult->statusCode = 1;
                    $jsonResult->statusMsg = '发送成功';


                    $newSmsCodeLog = [
                        'mobile' => $request->input('mobile'),
                        'smsCode' => $code,
                        'type' => 'register',
                        'detail' => $jsonResult->statusCode.':'.$jsonResult->statusMsg,
                        'expire' => date('Y-m-d H:i:s', time() + 60 * 60)
                    ];
                    $this->smsCodeLog->save($newSmsCodeLog);
                }
            }
             return response($jsonResult->toJson());
        }

        public function uploadImage(Request $request)
        {

            $imageObj=null;
            $resultObj =  new MessageResult();
            $token = $this->auth->uploadToken($this->bucket);
            $uploadMgr = new UploadManager();
            $status = 0;
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
                $imageObj = $this->image->save($newImage);
                if($imageObj != null || $imageObj->id > 0)
                {
                    $resultObj->statusCode = 1;
                    $resultObj->statusMsg='上传成功';
                    $resultObj->extra = $newImage;



                }
                else{
                    $resultObj->statusCode = 2;
                    $resultObj->statusMsg='插入数据入库失败';
                    $resultObj->extra = $newImage;
                }

            }
            else{
                $resultObj->statusCode = 3;
                $resultObj->Message='上传失败';
                $resultObj->extra = $result;
            }

          return response($resultObj->toJson());

        }


        public function deleteImage(Request $request){

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
                    $deleteRow=  $this->image->delete(['key'=>$imageKey]);
                    if($deleteRow)
                    {
                        $jsonResult->statusCode=1;
                        $jsonResult->statusMsg='删除成功';
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

            return response($jsonResult->toJson());
        }

    public function setImageCover(Request $request)
    {

        $type = $request->input('type');
        $associateId = $request->input('associateId');
        $imageId = $request->input('imageId');
        $jsonResult =  new MessageResult();

        if($type == 1)
        {
            $product = $this->product->find($associateId);
            if($product != null)
            {
                $product->thumb = $imageId;
                $product->save();
                $jsonResult->statusCode=1;
                $jsonResult->statusMessage='更改成功';
            }
        }
        return response($jsonResult->toJson());
    }

}
