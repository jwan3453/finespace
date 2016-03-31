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

        $obj = null;
        $count = 0;

        foreach($query as $q)
        {


            if($count == 0)
            {
                $obj = UserAccount::where($q['key'],$q['compare'],$q['value']);

            }
            else
            {
                $obj->where($q['key'],$q['compare'],$q['value']);

            }
            $count++;
        }

        return $obj;
    }

    public function deleteBy($query,$value){

        return UserAccount::where($query,$value)->delete();
    }


    public function save($obj)
    {

    }


}


