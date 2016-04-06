<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name=”viewport” content=”width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;” />
    <meta name=”viewport” content=”width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=false;” />
    <meta name=”viewport” content=”width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=no;” />
    <meta name="viewport" content="width=device-width, user-scalable=no" />
    <meta name="_token" content="{{ csrf_token() }}"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <link rel="stylesheet" type="text/css" href= {{ asset('semantic/dist/semantic.css') }}>
    <link rel="stylesheet" type="text/css" href= {{ asset('css/adminStyle.css') }}>

    <script src={{ asset('js/jquery-2.1.4.min.js') }}></script>
    <script src={{ asset('semantic/dist/semantic.js') }}></script>

    @yield('resources')
</head>

<body>

<div class="screen-bg blur">
</div>
<div class="screen-mask">
</div>


<div class="stick-top">
</div>

<div class="pos-spacing">

</div>

<div>
    <div class="f-left left-side-panel">
        <div class="ui  middle aligned animated list admin-menu ">
            <div class="item ">
                <i class=" f-left users icon"></i>
                <div class=" f-left content">商品</div>
                <i class="f-right  angle down icon"></i>
                <div class="ui  middle aligned animated list sub-menu ">
                    <div class="item ">
                        <a href="{{url('/weixin/admin/product')}}"> <i class="f-left right triangle icon"></i>
                        <div class="  f-left content">商品管理 </div></a>
                    </div>


                </div>
            </div>
            <div class="item ">
                <i class="  f-left marker icon"></i>
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

                </div>
            </div>
            <div class="item ">
                <i class="  f-left mail icon"></i>
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
                    <div class="item ">
                        <i class="f-left right triangle icon"></i>
                        <div class="  f-left  content">今日订单</div>
                    </div>

                </div>
            </div>
            <div class="item ">
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


                    $(this).siblings('.sub-menu').slideToggle(300);
                })
            })
            function _showToaster($message){
                $('.toaster').text($message);
                $('.toaster').fadeIn(500).fadeOut(2500 );
            }
</script>

@yield('script')
</html>