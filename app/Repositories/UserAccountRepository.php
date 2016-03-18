<?php
namespace App\Repositories;

use App\Models\UserAccount;


class UserAccountRepository implements  UserAccountRepositoryInterface{

    public function selectAll()
    {
        return UserAccount::all();
    }

    public function find($id)
    {
        return UserAccount::find($id);
    }


    public function findBy($query,$value){

        return UserAccount::where($query,$value)->get();
    }

    public function deleteBy($query,$value){

        return UserAccount::where($query,$value)->delete();
    }


    public function save($obj)
    {

    }


}


