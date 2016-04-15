<?php

namespace App\Http\Controllers\weixin;

use App\Repositories\UserAccountRepositoryInterface;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\Repositories\UserAccountRepository;
use App\Repositories\ImageRepositoryInterface;

use App\Tool\MessageResult;

class memberController extends Controller
{
    //

    private $userAcocunt;
    private $image;

    public function __construct(UserAccountRepositoryInterface $userAccount,ImageRepositoryInterface $image)
    {
        $this->userAccount = $userAccount;
        $this->image = $image;
    }

    public function home()
    {


        if(Auth::check())
        {
            $user = Auth::user();

            $user->headImg = $this->image->getUserHeadImg($user->id);

            $account = $this->userAccount->findBy(['user_id'=>$user->id])->first();
            return view('weixin.member.home')->with('user',$user)->with('account',$account);
        }

        return view('auth.login');
    }

    public function addPic(Request $request)
    {

        $jsonResult = new MessageResult();

        $count = $this->image->IsUserHeadImage($request->input('UserId'),3);

        if ($count > 0) {
            $key = $this->image->getImageKey($request->input('UserId'),3);

            $delRulst = $this->image->deleteImageSingle($key);

            if ($delRulst) {
                $jsonResult = $this->image->uploadImage($request);
            }
            else{
                $jsonResult->statusCode = 9;
                $jsonResult->statusMsg='删除失败';
            }

        }else{
            
            $jsonResult = $this->image->uploadImage($request);
           
        }

        return response($jsonResult->toJson());
        
    }

    public function DelUserHeadImg(Request $request)
    {
        $jsonResult = new MessageResult();
        
        $delRulst = $this->image->deleteImageSingle($request->input('key'));

        if ($delRulst) {
            $jsonResult->statusCode = 0;
            $jsonResult->statusMsg='删除成功';
        }else{
            $jsonResult->statusCode = 1;
            $jsonResult->statusMsg='删除失败';
        }

        return response($jsonResult->toJson());
    }
}
