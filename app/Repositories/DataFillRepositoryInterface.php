<?php

namespace App\Repositories;

interface DataFillRepositoryInterface{

    public function getTable();

    public function getTableStructure($table);

    public function random($length,$isNum);

    public function DataFill($request);

}
