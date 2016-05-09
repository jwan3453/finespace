<?php
namespace App\Repositories;
use App\Models\Permission;
use App\Models\Role;
use App\Models\PermissionRole;

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

        // 获取用户
        $user = User::where('mobile','=','15555555555')->first();

        // 可以使用 Entrust 提供的便捷方法用户授权
        // 注: 参数可以为 Role 对象, 数组, 或者 ID
        $user->attachRole( $admin ); 

        // 或者使用 Eloquent 自带的对象关系赋值
        $user->roles()->attach( 1 ); // id only
   }


   public function getAllPermissions()
   {
        $Permission_Roles = PermissionRole::all();

        // dd($Permission_Roles);

       return Permission::all();
   }

   public function AddPermission($insertArr)
   {
        $Permission = new Permission;
        $Permission->name = $insertArr['name'];
        $Permission->display_name = $insertArr['display_name'];
        if ($Permission->save()) {
          return true;
        }else{
          return false;
        }
   }

   public function getAllRole()
   {
      $RoleList = Role::all();
      
      return $RoleList;
   }

   public function updateOraddRole($dataArr)
   {
    // dd($dataArr);
      $Role = new Role;

      if ($dataArr['editOradd'] == 'edit') {
        // $Role->id = ;
        $newRole = Role::find($dataArr['roleid']);
        $newRole->name = $dataArr['name'];
        $newRole->display_name = $dataArr['display_name'];
        $newRole->description = $dataArr['description'];
        // $newRole->save();

        if ($newRole->save()) {
          return true;
        }else{
          return false;
        }

      }elseif ($dataArr['editOradd'] == 'add') {

        $Role->name = $dataArr['name'];
        $Role->display_name = $dataArr['display_name'];
        $Role->description = $dataArr['description'];
        // $Role->save();

        if ($Role->save()) {
          return true;
        }else{
          return false;
        }

      }
   }


   public function delRole($Roleid)
   {
     $Role = Role::find($Roleid);
     if ($Role->delete()) {
       return true;
        }else{
          return false;
        }
   }

   public function UserGroupPermission($id = 1)
   {
     $Permission = Permission::all();

     foreach ($Permission as $permission) {
       $premisson_role = PermissionRole::where('permission_id',$permission->id)->where('role_id',$id)->count();
       if ($premisson_role != '') {
          $permission->isRole = 1;
       }else{
          $permission->isRole = 0;
       }
     }
     return $Permission;
     // dd($Permission);
   }

   public function PermissionRole($dataArr)
   {
      $dataCount = PermissionRole::where('role_id',$dataArr['role_id'])->count();

      if ($dataCount > 0) {
          $DelData = PermissionRole::where('role_id',$dataArr['role_id'])->delete();
      }

      $role_id = $dataArr['role_id'];

      $isInsert = true;

      foreach ($dataArr['permission'] as $permission) {
          $insert = PermissionRole::insert(['permission_id'=>$permission,'role_id'=>$role_id]);

          if (!$insert) {
              $isInsert = false;

              break;
          }
      }

      if ($isInsert) {
        return true;
      }else{
        return false;
      }


   }

}


