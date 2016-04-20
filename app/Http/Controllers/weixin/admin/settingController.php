<?php

namespace App\Http\Controllers\weixin\admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
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

        return view('admin.weixinAdmin.setting.manageHomeSlide')->with('images',$images)
            ->with('slideType',1)->with('nav','编辑首页幻灯片');

    }

    public function editHomeSlide()
    {
        $images = $this->setting->getHomeSlides();
        return view('admin.weixinAdmin.setting.editHomeSlide')->with('images',$images)
            ->with('slideType',1)->with('nav','编辑首页幻灯片图片');
    }

    public function updateSlide(Request $request){

        $jsonResult  = new MessageResult();
        $status = $this->setting->updateSlide($request);
        if($status)
        {
            $jsonResult->statusCode = 1;
            $jsonResult->statusMsg='更新成功';
        }
        else{
            $jsonResult->statusCode = 2;
            $jsonResult->statusMsg='更新失败';
        }
        return response($jsonResult->toJson());


    }
    public function deleteSlide(Request $request){

        $jsonResult  = new MessageResult();
        $status = $this->setting->deleteSlide($request);
        if($status)
        {
            $jsonResult->statusCode = 1;
            $jsonResult->statusMsg='删除成功';
        }
        else{
            $jsonResult->statusCode = 2;
            $jsonResult->statusMsg='删除失败';
        }
        return response($jsonResult->toJson());
    }




}
