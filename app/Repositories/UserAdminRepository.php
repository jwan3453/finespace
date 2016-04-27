<?php
namespace App\Repositories;

use Hash;

use App\Models\UserAdmin;
use App\Models\Role;


class UserAdminRepository implements  UserAdminRepositoryInterface
{


    public function isAdmin($request)
    {
        //--是否有该用户名
        $admin = UserAdmin::where('username',$request['username'])->select('password')->first();
        $isLogin = false;
        //---验证密码是否正确
        if (Hash::check($request['password'], $admin->password)) {
            //---密码是否需要重新加密
            if (Hash::needsRehash($admin->password)) {
                $password = Hash::make($request['password']);
                //---将新的密码更新到数据
                UserAdmin::where('username',$request['username'])->update(['password'=>$password]);
            }

            $isLogin = true;
        }
        return $isLogin;
    }


    public function getAdminInfo($username)
        {
            $info = UserAdmin::where('username',$username)->first();
            return $info;
        } 

    public function getAllUserAdmin($paginate = 0)
       {
            if ($paginate != 0) {
                $list = UserAdmin::select('id','username','status','creat_time')->paginate($paginate);
            }else{
                $list = UserAdmin::select('id','username','status','creat_time')->get();
            }
      
            foreach ($list as $v) {
                if ($v->status != 0) {
                    $v->typename = Role::where('id',$v->status)->select('name')->first()->name;
                }else{
                    $v->typename = "超级管理员";
                }
                
            }

            return $list;
           
       } 

    public function getRole()
        {
            $list = Role::select('id','name')->get();
            return $list;
        }

    public function editOradd($request)
        {
            $editOradd = $request['editOradd'];
            $username = $request['username'];
            $selectrole = $request['selectrole'];
            $useradminId = $request['useradminId'];
            $password = $request['password'];

            $dataArr = array('username'=>$username,'status'=>$selectrole);

            if (!empty($password)) {
                $password = Hash::make($password);
                $dataArr['password'] = $password;
            }

            $isEditOrAdd = false;

            if ($editOradd == 'add') {
                $dataArr['creat_time'] = date('Y-m-d H:i:s');
                $isEditOrAdd = UserAdmin::insert($dataArr);
            }elseif ($editOradd == 'edit') {
               
                $isEditOrAdd = UserAdmin::where('id',$useradminId)->update($dataArr);
            }

            if ($isEditOrAdd) {
                return true;
            }else{
                return false;
            }
        }  

}