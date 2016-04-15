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


    private $product ;

    public function __construct( SmsCodeLogRepositoryInterface $smsCodeLog, ImageRepositoryInterface $image,
                                 ProductRepositoryInterface $product)
    {
        $this->smsCodeLog = $smsCodeLog;
        $this->image = $image;

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
                    $jsonResult->statusCode = 4;
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
            $jsonResult = new MessageResult();
            $jsonResult = $this->image->uploadImage($request);
            return response($jsonResult->toJson());
}


        public function deleteImage(Request $request){
            $jsonResult = new MessageResult();

            $jsonResult = $this->image->deleteImageSingle($request->input('imageKey'));

            return response($jsonResult->toJson());
        }

        public function setImageCover(Request $request)
        {

            $jsonResult =  new MessageResult();
            $jsonResult = $this->image->setImageCover($request);
            return response($jsonResult->toJson());
        }

}
