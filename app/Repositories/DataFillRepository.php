<?php
namespace App\Repositories;
// use App\Models\DataFill;
use Illuminate\Support\Facades\DB;

class DataFillRepository implements  DataFillRepositoryInterface{

    public function getTable()
    {
        $table = DB::select('SHOW TABLES');
        // dd($table);
        return $table;
    }

    public function getTableStructure($table)
    {
        $Structures = DB::select('SHOW FULL COLUMNS FROM '.$table);
        $Structure = array();
        foreach ($Structures as $v) {
            // dd($v->Field);
            $Structure[] = $v->Field;
        }
        return $Structure;
    }

    public function DataFill($request)
    {

        $table = $request['table']; //要插入的数据库表
        $num = $request['num'];  //要插入的数量

        unset($request['table']);  //将数据库表键从数组移除
        unset($request['num']);   //将插入数量键从数组移除

        $Structure = $this->getTableStructure($table); //获取该数据库表的字段

        unset($Structure['id']);  //将ID字段从数组中移除

        $insertArr = array();

        for ($i=0; $i < $num; $i++) { 
            
            foreach ($Structure as $key => $v) {
                $select_key = $v."_select";
                $min_key = $v."_min";
                $max_key = $v."_max";

                //是否存在该键值
                if (array_key_exists($select_key,$request)) {
                    switch ($request[$select_key]) {
                        case '1': //随机字符串
                            $data = $this->random($request[$min_key],'a');
                            break;
                        case '2': //随机数字
                            $data = rand($request[$min_key],$request[$max_key]);
                            break;
                        case '3': //固定值
                            $data = $request[$min_key];
                            break;
                        case '4': //时间区间
                            $timestamp = rand($request[$min_key],$request[$max_key]);
                            $data = date('Y-m-d H:i:s',$timestamp);
                            break;
                    }

                    $insertArr[$i][$v] = $data;

                }
            }
        }
        $is_T = true;
        foreach ($insertArr as $key => $vl) {
            $insertId = DB::table($table)->insertGetId($vl);
            if (!$insertId) {
                $is_T = false;
            }
        }
        
        return $is_T;

    }


    public function random($length,$isNum)
    {
        $random = '';
        $str = 'abcdefghijklmnopqrstuvwxyz1234567890';
        $num = '0123456789';
        if (is_numeric($isNum)){
            $sequece = 'num';
        }else{
            $sequece = 'str';
        }
        $max = strlen($$sequece) - 1;
        for ($i = 0; $i < $length; $i++)
        {
            $random .= ${$sequece}{mt_rand(0, $max)};
        }
        return $random;
    }

}


