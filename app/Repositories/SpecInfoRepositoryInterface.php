<?php

namespace App\Repositories;

interface SpecInfoRepositoryInterface{

    public function selectAll($paginate);

    public function updateOraddSpecInfo($request);

    public function delSpecInfo($id);



}
