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


    public function TodayUserCount()
    {
        $date = date('Y-m-d');
        // $date = '2016-04-14';
        $count = User::where('created_at' , 'like' , $date."%")->select('id')->count();
       
        return $count;
    }

    public function SevenDayUser()
    {
        $timeNow = time();

        $SevenDayUser = array();
        for ($i=6; $i > 0; $i--) { 
            $time = $timeNow;
            $time = $time - (3600 * 24 * $i);

            $today = date('Y-m-d' , $time);

            $count = User::where('created_at' , 'like' , $today."%")->select('id')->count();
            
            $SevenDayUser[$i]['count'] = $count;
            $SevenDayUser[$i]['date'] = $today;
        }
        return $SevenDayUser;
        // dd($SevenDayUser);
    }

    public function SevenDay()
    {
        $timeNow = time();

        $SevenDay = array();
        for ($i=6; $i > 0; $i--) { 
            $time = $timeNow;
            $time = $time - (3600 * 24 * $i);

            $today = date('Y-m-d' , $time);

            $SevenDay[$i] = $today;
        }
        return $SevenDay;
    }

    // public function findByUP($reque)
    // {
    //     # code...
    // }

    

}



