<?php
namespace App\Repositories;
use App\Models\SpecInfo;


class SpecInfoRepository implements  SpecInfoRepositoryInterface{

    public function selectAll($paginate = 0)
    {
        if ($paginate != 0) {
            return SpecInfo::orderBy('id','desc')->paginate($paginate);
        }
        else{
            return SpecInfo::orderBy('id','desc')->all();
        }
        
    }

    public function updateOraddSpecInfo($request)
    {
        $name = $request->input('name');
        $specId = $request->input('specId');
        $spec_level = $request->input('spec_level');
        $categoryid = $request->input('categoryid');
        $editOradd = $request->input('editOradd');

        $datetime = date('Y-m-d H:i:s',time());

        if ($editOradd == 'edit') {
            $isUpdateOrAdd = SpecInfo::where('id',$specId)->update(['name'=>$name,'spec_level'=>$spec_level,'category_id'=>$categoryid]);
        }else if ($editOradd == 'add') {
            $isUpdateOrAdd = SpecInfo::insert(['name'=>$name,'spec_level'=>$spec_level,'category_id'=>$categoryid]);
        }


        if ($isUpdateOrAdd) {
            return true;
        }
        else{
            return false;
        }
    }

    public function delSpecInfo($id)
    {
        $isDel = SpecInfo::where('id', $id)->delete();

        if ($isDel) {
            return true;
        }else{
            return false;
        }
    }

    
}


