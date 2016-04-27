<?php

namespace App\Http\Controllers\weixin\admin;

use Crypt;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\UserRepositoryInterface;
use App\Repositories\ProductRepositoryInterface;
use App\Repositories\OrderRepositoryInterface;
use App\Repositories\UserAdminRepositoryInterface;

use App\Tool\MessageResult;

class homeController extends Controller
{

    private $order;
    private $product;
    private $user;
    private $useradmin;


    function __construct(UserRepositoryInterface $user , ProductRepositoryInterface $product ,OrderRepositoryInterface $order , UserAdminRepositoryInterface $useradmin , Request $request)
    {
        $this->user = $user;
        $this->product = $product;
        $this->order = $order;
        $this->useradmin = $useradmin;


        if (!$request->session()->has('username')) {
        // dd($request->session()->has('username'));

            
            return view('admin.weixinAdmin.auth.login');

        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todayusercount = $this->user->TodayUserCount();
        $todayordercount = $this->order->TodayOrderCount();
        $todayincomesum = $this->order->TodayIncomeSum();
        $productcount = $this->product->getProductCount();

        return view('admin.weixinAdmin.home')->with('todayusercount',$todayusercount)->with('todayordercount',$todayordercount)->with('todayincomesum',$todayincomesum)->with('productcount',$productcount);
    }

    public function getChartData()
    {
        $resultjson = new MessageResult();
        $resultjson->SevenDay = $this->user->SevenDay();
        $resultjson->SevenDayUser = $this->user->SevenDayUser();
        $resultjson->SevenDayOrder = $this->order->SevenDayOrder();
        $resultjson->SevenDayIncome = $this->order->SevenDayIncome();

        // dd($resultjson->toJson());

        return response($resultjson->toJson());
    }

    public function loginPage()
    {
        return view('admin.weixinAdmin.auth.login');
    }

    public function Logout(Request $request)
    {
        $request->session()->forget('adminusername');
        $request->session()->forget('adminstatus');
    }

    public function login(Request $request)
    {
        $resultjson = new MessageResult();
        $adminSuccess = false;
        $useradmin = $this->useradmin->isAdmin($request->input());

        if ($useradmin) {
            $adminInfo = $this->useradmin->getAdminInfo($request->input('username'));
            $request->session()->put('adminusername',$adminInfo->username);
            $request->session()->put('adminstatus',$adminInfo->status);
            
            $adminSuccess = true;
        }


        if ($adminSuccess) {
            $resultjson->status = 1;
            $resultjson->Msg = "验证成功！";
        }else{
            $resultjson->status = 0;
            $resultjson->Msg = "验证失败！";
        }

        return response($resultjson->toJson());
        
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
