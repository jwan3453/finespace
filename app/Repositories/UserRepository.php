<?php
namespace App\Repositories;
use App\User;


class UserRepository implements  BaseRepositoryInterface{

    public function selectAll()
    {
        return User::all();
    }

    public function find($id)
    {
        return User::find($id);
    }


    public function findBy($query,$value){

        return User::where($query,$value)->first();
    }


}


