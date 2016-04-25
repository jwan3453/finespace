<?php
namespace App\Repositories;
use App\Models\Permission;
use App\Models\Role;

class PermissionRepository implements  PermissionRepositoryInterface{

   public function testPermission()
   {
        $admin = new Role;
        $admin->name = 'Admin';
        $admin->save();

        // Role::insert(['name'=>'Admin']);

        $manageUsers = new Permission;
        $manageUsers->name = 'manage_users';
        $manageUsers->display_name = 'Manage Users';
        $manageUsers->save();

        // Permission::insert(['name'=>'manage_suers','display_name'=>'Manage Users']);

        $admin->perms()->sync(array($managePosts->id));

        // 获取用户
        $user = User::where('mobile','=','15555555555')->first();

        // 可以使用 Entrust 提供的便捷方法用户授权
        // 注: 参数可以为 Role 对象, 数组, 或者 ID
        $user->attachRole( $admin ); 

        // 或者使用 Eloquent 自带的对象关系赋值
        $user->roles()->attach( $admin->id ); // id only
   }

}


