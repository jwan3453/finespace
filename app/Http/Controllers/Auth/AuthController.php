<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Tool\MessageResult;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\SmsCodeLogRepositoryInterface;
use App\Repositories\UserAccountRepositoryInterface;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;



    protected $redirectPath = '/weixin';
    protected $loginPath = '/auth/login';
    protected $username = 'mobile';
    protected $user;
    protected $smsCodeLog;
    protected $userAccount;
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */


    public function __construct(UserRepositoryInterface $user,SmsCodeLogRepositoryInterface $smsCodeLog,UserAccountRepositoryInterface $userAccount)
    {
        $this->user = $user;
        $this->smsCodeLog = $smsCodeLog;
        $this->middleware('guest', ['except' => 'getLogout']);
        $this->userAccount = $userAccount;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        // 1 正常　2手机已经注册   3 手机格式不对
        // 4 密码格式不对 5重复密码不正确 6验证码过期
        // 7.短信验证码错误

        $mobile = $data['mobile'];
        $password = $data['password'];
        $passwordConfirmation = $data['passwordConfirmation'];
        $smsCode = $data['verifySmsCode'];
        $check = 1;
        $mobileStatus = $this->checkMobile($mobile);

        if ($mobileStatus == 2)
            return  2;
        else if ($mobileStatus == 3)
            return  3;

        $passwordStatus = $this->checkPassword($password, $passwordConfirmation);
        if ($passwordStatus == 2)
            return 4;
        else if ($passwordStatus == 3)
            return 5;

        $smsCodeStatus = $this->checkSmsCode($mobile, $smsCode);
        if ($smsCodeStatus == 2)
            return 6;
        else if ($smsCodeStatus == 3)
            return 7;

        return $check;

    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $newUser = User::create([
            'name' => 'finespaceUser',
            'mobile' => $data['mobile'],
            'password' => bcrypt($data['password']),
            'email' => rand(1,200).'@qq.com'
        ]);

        //添加用户账号 数据库

        if ($newUser) {
            $s = $this->userAccount->newUserAccount($newUser->id);
        }
        
        return $newUser;
    }



    public function checkMobile($mobile)
    {


        if (!preg_match('/^1[0-9]{1}[0-9]{9}$/', $mobile)) {
            //用户名包含飞字母数据下划线的字符
            return   3;

        } else {
            //检查用户名是否已经存在
            $userObj = $this->user->findBy(['mobile'=>$mobile])->first();


            if ($userObj !=null) {
                //数据库有相同的用户名
                return 2;
            }
            else{

                return 1;

            }
        }
    }

    public function checkPassword($password, $passwordConfirmation)
    {
        if(!preg_match('/^[0-9a-zA-Z_]{6,12}$/',$password))
        {
            return 2;
        }
        else if($password != $passwordConfirmation)
        {
            return 3;
        }
        else{
            return 1;
        }

    }

    public function checkSmsCode($mobile,$smsCode)
    {
        $smsCodeObj = $this->smsCodeLog->findBy(['mobile'=>$mobile,'smsCode'=>$smsCode,'status'=>1])->orderBy('created_at','desc')->first();

        if($smsCodeObj == null)
        {
            return 3;
        }
        else if($smsCodeObj->expire < date('Y-m-d h:i:s',time()))
        {

            return 2;
        }
        else
            return  1;
    }

    public function clientCheckMobile (Request $request)
    {
       $jsonResult = new MessageResult;

        $mobile = trim($request->input('mobile'));


        $status = $this->checkMobile($mobile);

        //检查用户名 只能由字母和数据组成

        if($status == 1)
        {
            $jsonResult->statusCode = 1;
        }
        else if($status == 2)
        {
            $jsonResult->statusCode = 2;
            $jsonResult->statusMsg ='手机号已经被注册';
        }
        else if($status == 3)
        {

            $jsonResult->statusCode = 3;
            $jsonResult->statusMsg ='手机号格式不正确';

        }
        //$this->result->statusMsg = $request->session()->get('validateCode','');

        return response($jsonResult->toJson());
    }
}
