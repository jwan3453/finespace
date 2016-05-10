<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Models\Role;
use App\Models\RoleUser;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function isRolePermission($AdminId , $RoleName = "SuperAdmin" , $Permission = '')
    {

    	$userrole = RoleUser::where('user_id',$AdminId)->select('role_id')->first();
    	$RoleId = 1;
        $retData = false;
    	if ($userrole != '') {
    		$RoleId = $userrole->role_id;
    	}

    	$Role = Role::where('id',$RoleId)->select('name')->first();

    	if ($Role != '') {
    		$role_name = $Role->name;
    	}

    	if ($RoleName === $role_name) {
    		return true;
    	}else{
    		return false;
    	}

    }
}
