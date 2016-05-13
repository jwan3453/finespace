
<html >
<head>
    <meta charset="utf-8">
    <meta name=”viewport” content=”width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;” />
    <meta name=”viewport” content=”width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=false;” />
    <meta name=”viewport” content=”width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=no;” />
    <meta name="viewport" content="width=device-width, user-scalable=no" />
    <meta name="_token" content="{{ csrf_token() }}"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <link rel="stylesheet" type="text/css" href= {{ asset('semantic/dist/AdminSemantic.css') }}>
    <link rel="stylesheet" type="text/css" href= {{ asset('css/adminStyle.css') }}>

    <script src={{ asset('js/jquery-2.1.4.min.js') }}></script>
    <script src={{ asset('semantic/dist/AdminSemantic.js') }}></script>

    @yield('resources')
</head>

<body  >



<div class="screen-bg ">
    <img src="/img/admin_bg.jpg">
</div>

<div class="screen-mask">
</div>


<div class="stick-top">
    <a href="/weixin/admin" class="auto-margin">
    <div class="admin-logo">
        <img src ='/img/finespace.png'>
    </div>
    </a>





    <div class="admin-header-option f-right">



        <a href="/weixin/admin/order/StockingPage">
            <span class="today-order">今日到店订单</span>
            <span class="instore-order-alert">0</span>
        </a>

        <a href="/weixin/admin/order/today">
            <span class="today-order">今日订单</span>
            <span class="today-order-alert">0</span>
        </a>




        <a href="/weixin/admin/logout">退出登录 </a>
    </div>
</div>

<div class="pos-spacing">

</div>

<div >
    <div class="f-left left-side-panel">
        <div class="ui  middle aligned animated list admin-menu ">
            <div class="item ">
                <a class=" f-left icon-product"></a>
                <div class=" f-left content">商品</div>
                <i class="f-right  angle down icon"></i>
                <div class="ui  middle aligned animated list sub-menu ">
                    <div class="item ">
                        <a href="{{url('/weixin/admin/product')}}"> <i class="f-left right triangle icon"></i>
                        <div class="  f-left content">商品管理 </div></a>
                    </div>

                    <div class="item ">
                        <a href="{{url('/weixin/admin/product/rank')}}"> <i class="f-left right triangle icon"></i>
                            <div class="  f-left content">商品销售排名 </div></a>
                    </div>


                </div>
            </div>

            <div class="item ">
                <a class=" f-left icon-category"></a>
                <div class=" f-left content">产品分类</div>
                <i class="f-right  angle down icon"></i>
                <div class="ui  middle aligned animated list sub-menu ">
                    <div class="item ">
                        <a href="{{url('/weixin/admin/category')}}"> <i class="f-left right triangle icon"></i>
                        <div class="  f-left content">分类管理 </div></a>
                    </div>

                    <div class="item ">
                        <a href="{{url('/weixin/admin/categorySpec')}}"> <i class="f-left right triangle icon"></i>
                        <div class="  f-left content">属性管理 </div></a>
                    </div>


                </div>
            </div>

            <div class="item ">
                <a class="  f-left icon-order"></a>
                <div class="  f-left content">订单 </div>
                <i class="f-right angle down icon"></i>
                <div class="ui  middle aligned animated list sub-menu ">

                    <div class="item ">
                        <a href="{{url('/weixin/admin/order')}}">
                            <i class="f-left right triangle icon"></i>
                            <div class="  f-left  content">全部订单</div>
                        </a>
                    </div>
                    <div class="item ">
                        <a href="{{url('/weixin/admin/order/today')}}">
                            <i class="f-left right triangle icon"></i>
                            <div class="  f-left content">今日订单 </div>
                        </a>
                    </div>

                    <div class="item ">
                        <a href="{{url('/weixin/admin/order/StockingPage')}}">
                            <i class="f-left right triangle icon"></i>
                            <div class="  f-left content">订单备货 </div>
                        </a>
                    </div>

                    <div class="item ">
                        <a href="{{url('/weixin/admin/Statement')}}">
                            <i class="f-left right triangle icon"></i>
                            <div class="  f-left content">店员结单 </div>
                        </a>
                    </div>

                </div>
            </div>
            <div class="item ">
                <a class="  f-left icon-user"></a>
                <div class="  f-left  content">
                    用户管理
                </div>
                <i class="f-right angle down icon"></i>
                <div class="ui  middle aligned animated list sub-menu ">
                    <div class="item ">
                        <a href="/weixin/admin/user">
                            <i class="f-left right triangle icon"></i>
                            <div class="  f-left content">全部用户 </div>
                        </a>
                    </div>
                 <!--    <div class="item ">
                        <i class="f-left right triangle icon"></i>
                        <div class="  f-left  content">今日订单</div>
                    </div> -->

                    

                </div>
            </div>
         <!--    <div class="item ">
                <i class="  f-left linkify icon"></i>
                <div class="  f-left content">
                    今日账单
                </div>
                <i class="f-right angle down icon"></i>
                <div class="ui  middle aligned animated list sub-menu ">
                    <div class="item ">
                        <i class="f-left right triangle icon"></i>
                        <div class="  f-left content">商品总类 </div>
                    </div>
                    <div class="item ">
                        <i class="f-left right triangle icon"></i>
                        <div class="  f-left  content">今日订单</div>
                    </div>

                </div>
            </div> -->


            <div class="item ">
                <a class=" f-left icon-store"></a>
                <div class=" f-left content">门店管理</div>
                <i class="f-right  angle down icon"></i>
                <div class="ui  middle aligned animated list sub-menu ">
                    <div class="item ">
                        <a href="{{url('/weixin/admin/store')}}"> <i class="f-left right triangle icon"></i>
                        <div class="  f-left content">门店列表 </div></a>
                    </div>


                </div>
            </div>

            <div class="item ">
                <a class="  f-left icon-system"></a>
                <div class="  f-left content">
                    系统设置
                </div>
                <i class="f-right angle down icon"></i>
                <div class="ui  middle aligned animated list sub-menu ">
                    <div class="item ">
                        <a href="/weixin/admin/manageHomeSlide">
                            <i class="f-left right triangle icon"></i>
                            <div class="  f-left content">首页幻灯片</div>
                        </a>
                    </div>

                </div>
            </div>

            <div class="item ">
                <a class="  f-left icon-permission"></a>
                <div class="  f-left content">
                    权限管理
                </div>
                <i class="f-right angle down icon"></i>
                <div class="ui  middle aligned animated list sub-menu ">
                    <div class="item ">
                        <a href="/weixin/admin/Permission">
                            <i class="f-left right triangle icon"></i>
                            <div class="  f-left content">权限管理</div>
                        </a>
                    </div>

                    <div class="item ">
                        <a href="/weixin/admin/UserGroup">
                            <i class="f-left right triangle icon"></i>
                            <div class="  f-left content">用户组管理</div>
                        </a>
                    </div>

                </div>
            </div>

            <div class="item ">
                <a class="  f-left icon-adminuser"></a>
                <div class="  f-left content">
                    管理员管理
                </div>
                <i class="f-right angle down icon"></i>
                <div class="ui  middle aligned animated list sub-menu ">
                    <div class="item ">
                        <a href="/weixin/admin/userAdmin">
                            <i class="f-left right triangle icon"></i>
                            <div class="  f-left content">管理员列表</div>
                        </a>
                    </div>

                </div>
            </div>

            <div class="item ">
                <a class="  f-left icon-datafill"></a>
                <div class="  f-left content">
                    数据填充
                </div>
                <i class="f-right angle down icon"></i>
                <div class="ui  middle aligned animated list sub-menu ">
                    <div class="item ">
                        <a href="/weixin/admin/DataFill">
                            <i class="f-left right triangle icon"></i>
                            <div class="  f-left content">数据填充</div>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="toaster-box big-font ">
        <div class="toaster "></div>
    </div>
    @yield('content')

</div>



</body>

<script type="text/javascript">


            $(document).ready(function(){

                //$('.right-side-panel').css('width', $(window).width()-$('.left-side-panel').width());

                $('.angle.down').click(function(){


                })

                $.ajax({
                    url:'/weixin/getOrderNotification',
                    type: 'POST',
                    async: false,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success: function (data) {

                        $('.instore-order-alert').text(data.extra['todayInstoreOrder']);
                        $('.today-order-alert').text(data.extra['todayOrder']);
                    },
                    error: function (xhr, type) {
                        //todo
                    }
                })


            })
            function _showToaster($message){
                $('.toaster').text($message).fadeIn(500).fadeOut(2500 );

            }
</script>

@yield('script')
</html>