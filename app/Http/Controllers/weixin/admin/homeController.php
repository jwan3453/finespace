<?php

namespace App\Http\Controllers\weixin\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\UserRepositoryInterface;
use App\Repositories\ProductRepositoryInterface;
use App\Repositories\OrderRepositoryInterface;

use App\Tool\MessageResult;

class homeController extends Controller
{

    private $order;
    private $product;
    private $user;


    function __construct(UserRepositoryInterface $user , ProductRepositoryInterface $product ,OrderRepositoryInterface $order)
    {
        $this->user = $user;
        $this->product = $product;
        $this->order = $order;
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

        return view('admin.weixinAdmin.home')->with('todayusercount',$todayusercount)->with('todayordercount',$todayordercount)->with('todayincomesum',$todayincomesum);
    }

    public function getChartData()
    {
        $resultjson = new MessageResult();
        $resultjson->SevenDay = $this->user->SevenDay();
        $resultjson->SevenDayUser = $this->user->SevenDayUser();
        $resultjson->SevenDayOrder = $this->order->SevenDayOrder();
        $resultjson->SevenDayIncome = $this->order->SevenDayIncome();

        // dd($resultjson->toJson());
        return $resultjson->toJson();
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
