<?php

namespace App\Http\Controllers\weixin\admin;


use App\Models\Product;
use App\Repositories\OrderRepositoryInterface;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\UserAccountRepositoryInterface;
use App\Repositories\OrderItemRepositoryInterface;

use App\Tool\MessageResult;


class userController extends Controller
{
    //

    private $user;
    private $userAccount;
    private $order;

    public function __construct(UserRepositoryInterface $user,UserAccountRepositoryInterface $userAccount,
                                OrderRepositoryInterface $order)
    {

        $this->user =$user;
        $this->userAccount = $userAccount;
        $this->order = $order;
    }


    public function index()
    {

        return view('admin.weixinAdmin.home');
    }

    public function manageUser()
    {
        $users = $this->user->selectAll(10);
        return view('admin.weixinAdmin.user.manageUser')->with('users',$users);

    }

    public function userDetail($id)
    {
        $user=$this->user->find($id);
        $account= null;

        if($user != null)
        {

            $account =$this->userAccount->findBy(['user_id'=>$user->id])->first();


            $query = [
                [
                    'key' => 'user_id',
                    'compare'=>'=',
                    'value'=> $user->id
                ]
            ];
            $orders  =$this->order->findBy($query)->paginate(4);

            $totalAmount = 0;
            foreach($orders as $order)
            {
                $totalAmount = $totalAmount + $order->total_amount;
            }

            return view('admin.weixinAdmin.user.userDetail')->with('user',$user)
                                                    ->with('account',$account)
                                                    ->with('orders',$orders)
                                                    ->with('totalAmount',$totalAmount   );
        }
        else
        {
            //错误页面
            return '页面不存在';

        }
    }

}
