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


    public function findBy($query){

        return UserAccount::where($query);
    }




    public function newUserAccount($id)
    {
        $creatUser = UserAccount::insert(['user_id'=>$id,'amount'=>0,'last_update_time'=>date('Y-m-d H:i:s',time())]);

        if ($creatUser) {
            return true;
        }else{
            return false;
        }
    }


}


