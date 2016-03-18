<?php

namespace App\Http\Controllers\Service;


use Illuminate\Http\Request;

use App\Http\Requests;


use App\Http\Controllers\Controller;

use App\Tool\ValidateCode;
use App\Tool\SendTemplateSMS;
use App\Tool\MessageResult;

class CommonController extends Controller
{
    //
    public $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }



    public function generateSmsCode(){
            return $CheckCode= rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);
        }
        public function createValidateCode($value = '')
        {
            $validateCode = new ValidateCode;
            $valideImg =  $validateCode->doimg();
            $this->request->session()->put('validateCode',$validateCode->getCode());


            return $valideImg;


        }

        public function sendSmsCode(Request $request)
        {
            //$smscode = new sendTemplateSMS;
            $jsonObj = new MessageResult();

            $result = 0;//$smscode->sendTemplateSMS($request->input('mobile') ,array($this->generateSmsCode(),60),1);
            if(!isset($result)  ) {
                echo "result error!";

            }
            if($result !=0) {//if($result->statusCode!=0) {

//                $jsonObj->statusCode =  $result->statusCode;
//                $jsonObj->statusMsg= $result->statusMsg ;


                //TODO 添加错误处理逻辑
                $jsonObj->statusCode=1;
            }else{
//                echo "Sendind TemplateSMS success!<br/>";
//                // 获取返回信息
//                $smsmessage = $result->TemplateSMS;
//                echo "dateCreated:".$smsmessage->dateCreated."<br/>";
//                echo "smsMessageSid:".$smsmessage->smsMessageSid."<br/>";
                //TODO 添加成功处理逻辑

                $jsonObj->statusCode = 0;
                $jsonObj->statusMsg='发送成功';
            }

                return response($jsonObj->toJson());

        }



}
