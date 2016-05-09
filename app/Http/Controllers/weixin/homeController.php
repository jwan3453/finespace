<?php
namespace App\Http\Controllers\weixin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepositoryInterface;
use Auth,App\User,App\Models\Permission,App\Models\Role;
use  Zizaco\Entrust\Traits\EntrustUserTrait;
use App\Repositories\SettingRepository;

use App\Models\Product;
use App\Repositories\CategoryRepositoryInterface;
use App\Repositories\ProductRepositoryInterface;

use Zizaco\Entrust\Entrust;

class homeController extends Controller
{
    //
    private $user;
    private $setting;
    private $product;
    public function __construct(UserRepositoryInterface $user,SettingRepository $setting , ProductRepositoryInterface $product)
    {
        $this->user = $user;
        $this->setting = $setting;
        $this->product = $product;
    }
    public function index(Request $request)
    {
        $images =  $this->setting->getHomeSlides();
        $hotProducts = $this->product->getHotProduct();
        $recomProducts = $this->product->getRecomProduct();
        $newProducts = $this->product->getComboProduct();
        $categoryList = $this->product->getCategoryList();

        return view('weixin.home')->with('images',$images)->with('categoryList',$categoryList)->with('hotProducts',$hotProducts)->with('recomProducts',$recomProducts)
                                  ->with('newProducts',$newProducts);
    }
}

?>