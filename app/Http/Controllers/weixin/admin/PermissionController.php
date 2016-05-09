<?php

namespace App\Http\Controllers\weixin\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\PermissionRepositoryInterface;

use App\Tool\MessageResult;

class PermissionController extends Controller
{

    private $permission;

    function __construct(PermissionRepositoryInterface $permission)
    {
        $this->permission = $permission;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Permission = $this->permission->getAllPermissions();
        
        return view('admin.weixinAdmin.permission.Permission')->with('Permission',$Permission);
    }

    public function AddPermission(Request $request)
    {
        $add = $this->permission->AddPermission($request->input());

        $jsonResult = new MessageResult();
        if($add)
        {

            $jsonResult->statusCode=1;
            $jsonResult->statusMsg="添加成功";
        }
        else
        {
            $jsonResult->statusCode=2;
            $jsonResult->statusMsg="添加失败";
        }
        return response($jsonResult->toJson());
    }


    public function UserGroup()
    {
        $RoleLst = $this->permission->getAllRole();
        return view('admin.weixinAdmin.permission.UserGroup')->with('RoleLst',$RoleLst);
    }

    public function updateOraddRole(Request $request)
    {
        $isUpdate = $this->permission->updateOraddRole($request->input());

        $result_msg = $request->input('editOradd') == "add" ? "添加" : "更新";
        $jsonResult = new MessageResult();
        if ($isUpdate) {
            $jsonResult->statusCode=1;
            $jsonResult->statusMsg= $result_msg . "成功";
        }else{
            $jsonResult->statusCode=2;
            $jsonResult->statusMsg= $result_msg . "失败";
        }

        return response($jsonResult->toJson());
    }

    public function delRole(Request $request)
    {
        $del = $this->permission->delRole($request->input('id'));

        $jsonResult = new MessageResult();
        if($del)
        {

            $jsonResult->statusCode=1;
            $jsonResult->statusMsg="删除成功";
        }
        else
        {
            $jsonResult->statusCode=2;
            $jsonResult->statusMsg="删除失败";
        }
        return response($jsonResult->toJson());
    }

    public function UserGroupPermission($id = 1)
    {
        $PermissionRole = $this->permission->UserGroupPermission($id);
        return view('admin.weixinAdmin.permission.UserGroupPermission')->with('PermissionRole',$PermissionRole)->with('role_id',$id);
    }

    public function PermissionRole(Request $request)
    {
        // dd($request->input());
        $this->permission->PermissionRole($request->input());

        $RoleLst = $this->permission->getAllRole();
        return view('admin.weixinAdmin.permission.UserGroup')->with('RoleLst',$RoleLst);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
