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

}


