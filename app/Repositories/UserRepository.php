<?php
namespace App\Repositories;
use App\User;


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
        $test = new User();
        $test1 = new User();    
        return User::where($request);

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



