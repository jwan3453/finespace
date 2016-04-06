<?php

namespace App\Http\Controllers\weixin;

use App\Repositories\UserAccountRepositoryInterface;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\Repositories\UserAccountRepository;

class memberController extends Controller
{
    //

    private $userAcocunt;

    public function __construct(UserAccountRepositoryInterface $userAccount)
    {
        $this->userAccount = $userAccount;
    }

    public function home()
    {


        if(Auth::check())
        {
            $user = Auth::user();
            $account = $this->userAccount->findBy(['user_id'=>$user->id])->first();
            return view('weixin.member.home')->with('user',$user)->with('account',$account);
        }

        return view('auth.login');
    }
}
