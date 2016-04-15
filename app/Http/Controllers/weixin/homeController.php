<?php

namespace App\Http\Controllers\weixin;


use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepositoryInterface;
use Auth,App\User,App\Models\Permission,App\Models\Role;
use  Zizaco\Entrust\Traits\EntrustUserTrait;
use App\Repositories\SettingRepository;

class homeController extends Controller
{
    //

    private $user;
    private $setting;

    public function __construct(UserRepositoryInterface $user,SettingRepository $setting)
    {
        $this->user = $user;
        $this->setting = $setting;
    }


    public function index()
    {

        $images =  $this->setting->getHomeSlides();
        return view('weixin.home')->with('images',$images);
    }
}
