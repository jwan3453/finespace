<?php

namespace App\Models;

use Zizaco\Entrust\EntrustPermission;
use Illuminate\Database\Eloquent\Model;

    class PermissionRole extends EntrustPermission
{
        protected $table = 'permission_role';
        
}