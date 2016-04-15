<?php

namespace App\Http\Controllers\weixin\admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;


use App\Tool\MessageResult;
use App\Repositories\SettingRepositoryInterface;

class settingController  extends Controller
{
    //

    private  $setting;
    public function __construct(SettingRepositoryInterface $setting)
    {
        $this->setting = $setting;
    }

    public function manageHomeSlide()
    {
        $images = $this->setting->getHomeSlides();

        return view('admin.weixinAdmin.common.addImage')->with('images',$images)
            ->with('slideType',1)->with('nav','编辑首页幻灯片');

    }




}
