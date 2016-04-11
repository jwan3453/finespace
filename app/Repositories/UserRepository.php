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
    public function findBy($request)
    {
        $test = new User();
        $test1 = new User();    
        return User::where($request);

    }
}



