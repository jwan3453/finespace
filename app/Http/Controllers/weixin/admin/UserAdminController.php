<?php

namespace App\Http\Controllers\weixin\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\UserAdminRepositoryInterface;

use App\Tool\MessageResult;

class UserAdminController extends Controller
{
    private $useradmin;

    function __construct(UserAdminRepositoryInterface $useradmin)
    {
        $this->useradmin = $useradmin;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $AdminId = session('adminid');

        // dd($AdminId);
        $is = $this->isRolePermission($AdminId,"SuperAdmin");

        // dd($is);
        if (!$is) {
            return view('admin.weixinAdmin.error.RoleError');
        }

        $list = $this->useradmin->getAllUserAdmin(6);
        return view('admin.weixinAdmin.useradmin.UserAdmin')->with('list',$list);
    }

    public function getRole()
    {
        $roleList = new MessageResult();
        $roleList = $this->useradmin->getRole();
        return response($roleList->toJson());
    }

    public function editOraddUserAdmin(Request $request)
    {
        $isEditOrAdd = $this->useradmin->editOradd($request->input());

        $result_msg = $request->input('editOradd') == "add" ? "添加" : "更新";
        $jsonResult = new MessageResult();
        if ($isEditOrAdd) {
            $jsonResult->statusCode=1;
            $jsonResult->statusMsg= $result_msg . "成功";
        }else{
            $jsonResult->statusCode=2;
            $jsonResult->statusMsg= $result_msg . "失败";
        }

        return response($jsonResult->toJson());
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
