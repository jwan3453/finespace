<?php

namespace App\Http\Controllers\weixin\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\StoreRepositoryInterface;

use App\Tool\MessageResult;

class storeController extends Controller
{
    private $store;

    public function __construct(StoreRepositoryInterface $store)
    {
        $this->store = $store;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $StoreList = $this->store->selectAll();
        // dd($StoreList);
        return view('admin.weixinAdmin.store.StoreList')->with('StoreList',$StoreList);
    }

    public function updateOraddStore(Request $request)
    {
        $updateOraddStore = $this->store->updateOraddStore($request);
        $result_msg = $request->input('editOradd') == "add" ? "添加" : "更新";
        $jsonResult = new MessageResult();
        if ($updateOraddStore) {
            $jsonResult->statusCode=1;
            $jsonResult->statusMsg= $result_msg . "成功";
        }else{
            $jsonResult->statusCode=2;
            $jsonResult->statusMsg= $result_msg . "失败";
        }

        return response($jsonResult->toJson());
    }

    public function delStore(Request $request)
    {
        $id = $request->input('id');
        $isDel = $this->store->delStore($id);

        $jsonResult = new MessageResult();

        if ($isDel) {
            $jsonResult->statusCode=1;
            $jsonResult->statusMsg= "删除成功";
        }else{
            $jsonResult->statusCode=2;
            $jsonResult->statusMsg= "删除失败";
        }

        return response($jsonResult->toJson());
    }
}
