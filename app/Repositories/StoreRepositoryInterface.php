<?php

namespace App\Repositories;

interface StoreRepositoryInterface{

    public function selectAll();

    public function find($id);

    public function updateOraddStore($request);



}
