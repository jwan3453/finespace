<?php
namespace App\Repositories;
use App\Models\Store;


class StoreRepository implements  StoreRepositoryInterface{

    public function selectAll()
    {
        return Store::all();
    }

    public function find($id)
    {
        return Store::find($id);
    }

    public function updateOraddStore($request)
    {
        $name = $request->input('name');
        $address = $request->input('address');
        $phone = $request->input('phone');
        $id = $request->input('storeid');
        $editOradd = $request->input('editOradd');
        $is_distribution = $request->input('is_distribution');
        $is_display = $request->input('is_display');

        $datetime = date('Y-m-d H:i:s',time());

        if ($editOradd == 'edit') {
            $isUpdateOrAdd = Store::where('id',$id)->update(['name'=>$name,'address'=>$address,'phone'=>$phone,'is_distribution'=>$is_distribution,'is_display'=>$is_display]);
        }else if ($editOradd == 'add') {
            $isUpdateOrAdd = Store::insert(['name'=>$name,'address'=>$address,'phone'=>$phone,'is_distribution'=>$is_distribution,'is_display'=>$is_display]);
        }


        if ($isUpdateOrAdd) {
            return true;
        }
        else{
            return false;
        }

    }

    public function delStore($id)
    {
        $isDel = Store::where('id', $id)->delete();

        if ($isDel) {
            return true;
        }else{
            return false;
        }
    }

}


