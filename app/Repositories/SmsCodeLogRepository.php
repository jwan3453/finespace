<?php
namespace App\Repositories;
use App\Models\SmsCodeLog;


class SmsCodeLogRepository implements  SmsCodeLogRepositoryInterface{

    public function selectAll()
    {
        return SmsCodeLog::all();
    }

    public function find($id)
    {
        return SmsCodeLog::find($id);
    }

//
    public function findBy($query){


        return SmsCodeLog::where($query);
    }

    public function update($query)
    {
        return SmsCodeLog::where($query['where'])->update($query['update']);
    }

    public function save($obj)
    {

        $newSmsCodeLog = new SmsCodeLog();
        $newSmsCodeLog->mobile = $obj['mobile'];
        $newSmsCodeLog->smsCode = $obj['smsCode'];
        $newSmsCodeLog->type = $obj['type'];
        $newSmsCodeLog->detail = $obj['detail'];
        $newSmsCodeLog->expire = $obj['expire'];
        $newSmsCodeLog->status = $obj['status'];


        $newSmsCodeLog->save();
        return $newSmsCodeLog;

    }


}


?>