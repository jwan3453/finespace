<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryInterface;
use App\Tool\MessageResult;
use Illuminate\Foundation\Auth\ResetsPasswords;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Repositories\SmsCodeLogRepositoryInterface;
use App\Repositories\UserAccountRepository;

class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Create a new password controller instance.
     *
     * @return void
     */

    private $smsCodeLog;
    private $user;
    public function __construct( SmsCodeLogRepositoryInterface $smsCodeLog,UserRepositoryInterface $user)
    {
        $this->smsCodeLog = $smsCodeLog;
        $this->user = $user;
        $this->middleware('guest');

    }



    public function resetPassword()
    {
        return view('auth.resetPassword');
    }

    public function setPassword(Request $request)
    {
        $jsonResult = new MessageResult();
        $mobile = $request->input('mobile');
        $code = $request->input('verifySmsCode');
        $newPassword = $request->input('newPassword');
        $smsCodeObj = $this->smsCodeLog->findBy(['mobile'=>$mobile,'smsCode'=>$code,'status'=>1])->orderBy('created_at','desc')->first();

        //验证码输入正确
        //修改密码
        if($smsCodeObj != null && $smsCodeObj->expire >= date('Y-m-d h:i:s',time()))
        {
            $jsonResult->statusCode = $this->user->setPassword($mobile,$newPassword);
            if($jsonResult->statusCode = 1)
                $jsonResult->statusMsg ='密码更新成功';
            else
                $jsonResult->statusMsg ='密码跟新失败';

        }
        //找不到验证码 或者 验证码过期
        else{
            $jsonResult->statusCode  = 3;
            $jsonResult->statusMsg ='短信验证码错误';
        }


        return response($jsonResult->toJson());
    }
}
