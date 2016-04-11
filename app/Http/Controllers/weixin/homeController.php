<?php

namespace App\Http\Controllers\weixin;


use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepositoryInterface;
use Auth,App\User,App\Models\Permission,App\Models\Role;
use  Zizaco\Entrust\Traits\EntrustUserTrait;

class homeController extends Controller
{
    //

    private $user;

    public function __construct(UserRepositoryInterface $user)
    {
        $this->user = $user;
    }


    public function index()
    {


        $currentUser ='';
        return view('weixin.home')->with('currentUser',$currentUser);
    }
}
