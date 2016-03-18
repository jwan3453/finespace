<?php

namespace App\Http\Controllers\Service;


use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\BaseRepositoryInterface;
use App\Tool\MessageResult;


class AuthCheckController extends Controller
{
    //

    private $user;

    private $result;

    public function __construct(BaseRepositoryInterface $user)
    {
        $this->user = $user;
    }


    public function checkMobile (Request $request)
    {
       $this->result = new MessageResult;

        $mobile = trim($request->input('mobile'));


        //检查用户名 只能由字母和数据组成

        if (!preg_match('/^1[0-9]{1}[0-9]{9}$/', $mobile)) {
            //用户名包含飞字母数据下划线的字符
            $this->result->statusCode = 2;
            $this->result->statusMsg ='手机号格式不正确';
        } else {
            //检查用户名是否已经存在
            $userObj = $this->user->findBy('mobile',$mobile);

            if ($userObj !=null) {
                //数据库有相同的用户名
                $this->result->statusCode = 1;
                $this->result->statusMsg ='手机号已经被注册';
            }
            else{
                $this->result->statusCode = 0;

            }
        }
        //$this->result->statusMsg = $request->session()->get('validateCode','');

        return response($this->result->toJson());
    }
}
