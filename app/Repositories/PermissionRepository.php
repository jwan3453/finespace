<?php
namespace App\Repositories;
use App\Models\Permission;
use App\Models\Role;

use App\User;

class PermissionRepository implements  PermissionRepositoryInterface{

   public function testPermission()
   {


        $admin = new Role();
        // $RoleArr = array('name'=>"Admin2");
        // $admin->createAdmin($RoleArr);

        // $admin->name = "amdin4";
        // $admin->save();

        // // Role::insert(['name'=>'Admin']);

        // $manageUsers = new Permission;
        // // $manageUsersArr = array('name'=>"manage_users",'display_name'=>"Manage Users");
        // $manageUsers->name = 'manage_users4';
        // $manageUsers->display_name = 'Manage Users4';
        // $manageUsers->save();

        // Permission::insert(['name'=>'manage_suers','display_name'=>'Manage Users']);

        $admin->perms()->sync(array(1,array('role_id'=>1)));
        echo $admin->id."-----";
        dd($admin);

        // 获取用户
        $user = User::where('mobile','=','15555555555')->first();

        // 可以使用 Entrust 提供的便捷方法用户授权
        // 注: 参数可以为 Role 对象, 数组, 或者 ID
        $user->attachRole( $admin ); 

        // 或者使用 Eloquent 自带的对象关系赋值
        $user->roles()->attach( 1 ); // id only
   }

}


