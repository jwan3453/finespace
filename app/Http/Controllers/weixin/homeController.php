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





       // $currentUser =Auth::getUser()->getAttributeValue('id');


//
//        $user = user::where('id',1)->first();
//
//        echo $user->hasRole('owner');   // false
//        echo $user->hasRole('admin');   // true
//        echo $user->may('edit-user');   // false
//        echo $user->may('create-post'); // true
//        dd("test");
        return view('weixin.home',compact('currentUser'));
    }
}
