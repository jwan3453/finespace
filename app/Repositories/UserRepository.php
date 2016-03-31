<?php
namespace App\Repositories;
use App\User;


class UserRepository implements  UserRepositoryInterface{

    public function selectAll($paginate = 0)
    {
        if($paginate!=0)
            return User::paginate($paginate);
        else

            return User::all();
    }

    public function find($id)
    {
        return User::find($id);
    }

    public function findBy($query){

        return User::where($query)->get();
    }
}


