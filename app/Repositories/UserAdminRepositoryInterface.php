<?php

namespace App\Repositories;

interface UserAdminRepositoryInterface{

    public function isAdmin($request);

    public function getAdminInfo($username);

    public function getAllUserAdmin($paginate = 0);

}
