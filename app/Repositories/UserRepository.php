<?php
namespace App\Repositories;
use App\User;
use App\Models\UserAccount;
use App\Models\Order;


class UserRepository implements  UserRepositoryInterface
{

    public function selectAll($paginate = 0)
    {
        if ($paginate != 0)
            return User::paginate($paginate);
        else

            return User::all();
    }

    public function find($id)
    {
        return User::find($id);
    }

    //welcome our new freind
    //xin de comment
    //change somethings
    public function findBy($request)
    {
        return User::where($request);

    }


    public function getUserDetail($user)
    {

        $account = userAccount::where('user_id',$user->id)->first();
        $orders  = Order::where('user_id', $user->id)->paginate(4);

        $userDetail['account'] = $account;
        $userDetail['orders'] = $orders;

        $totalAmount = 0;
        foreach($orders as $order)
        {
            $totalAmount = $totalAmount + $order->total_amount;
        }
        $userDetail['totalAmount'] = $totalAmount;

        return $userDetail;
    }

    public function setPassword($mobile,$newPassword)
    {
        $user = User::where('mobile',$mobile)->first();
        $status = 2;
        if($user!=null)
        {
            $user->password = bcrypt($newPassword);
            $status = $user->save();
        }
        return $status;
    }
}



