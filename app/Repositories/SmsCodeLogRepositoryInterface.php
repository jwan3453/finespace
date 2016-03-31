<?php

namespace App\Repositories;

interface SmsCodeLogRepositoryInterface{

    public function selectAll();

    public function find($id);

    public function findBy($query );



    public function save($obj);

}
