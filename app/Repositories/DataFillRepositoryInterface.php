<?php

namespace App\Repositories;

interface DataFillRepositoryInterface{

    public function getTable();

    public function getTableStructure($table);

}
