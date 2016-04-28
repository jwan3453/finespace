@extends('weixinsite')


@section('resources')
    <script src={{ asset('js/jquery.fly.min.js') }}></script>
    <script src={{ asset('js/swiper/owl.carousel.min.js') }}></script>
    <script src={{ asset('js/swiper/owl.carousel.min.js') }}></script>

    <link rel="stylesheet" type="text/css" href= {{ asset('js/swiper/owl.carousel.min.css') }}>
    <link rel="stylesheet" type="text/css" href= {{ asset('js/swiper/owl.theme.default.min.css') }}>

@stop

@section('content')

    <div class="ui  container" style=" overflow:hidden;" id="homepage">
        <div >
            <div class="owl-carousel owl-theme">
                @foreach($images as $img)
                    <div class="item" > <img style="width:100%;" src = {{$img->link}}></div>
                @endforeach
            </div>
        </div>

        <div class="product-cate">
            <div class="f-left  cake ">凡悦蛋糕</div>
            <div class="f-left coffee">凡悦下午茶</div>
            <div class="f-left combo">凡悦套餐</div>
        </div>

            <div class="product-sub-cate " id="cake">
                @foreach($categoryList['蛋糕'] as $category)
                    <div class="column cat_border f-left" >
                        <a  href="/weixin/CateProList/{{$category->id}}">
                            <span class="big-font">{{$category->name}}</span>
                        </a>
                    </div>
                @endforeach
            </div>

        <div class="product-sub-cate " id="coffee">
            @foreach($categoryList['咖啡'] as $category)
                <div class="column cat_border " >
                    <a  href="/weixin/CateProList/{{$category->id}}">
                        <span class="big-font">{{$category->name}}</span>
                    </a>
                </div>
            @endforeach
        </div>

        <div class="product-sub-cate " id="combo">
            @foreach($categoryList['套餐'] as $category)
                <div class="column cat_border " >
                    <a  href="/weixin/CateProList/{{$category->id}}">
                        <span class="big-font">{{$category->name}}</span>
                    </a>
                </div>
            @endforeach
        </div>





        <!-- 精品推荐-->
        <div class="white-background recommend-sect">
            <div class="sect-header">

                    <h4>精品推荐

                    </h4>

            </div>

            <div class="recommend-products">

                @foreach($recomProducts as $recomProduct)

                        <div class="item " >
                            <a href="/weixin/product/{{$recomProduct->id }}"><img src="{{$recomProduct->img }}"></a>
                            <div class="product-name auto-margin">{{$recomProduct->name }}</div>
                            {{--<div class="price-info">--}}
                                {{--<span class="f-left big-font">￥{{$recomProduct->price }}</span>--}}
                            {{--</div>--}}
                        </div>
                @endforeach
            </div>
            <a href="weixin/product/sellCategory/1" class="black-anchor see-all">
                <div >
                    <span class="f-right">查看全部<i class="chevron circle right icon large "></i>
                    </span>
                </div>
            </a>
        </div>

        <!-- 最热单品-->
        <div class="white-background hot-sect">
            <div class="sect-header">

                <h4>最热单品
                </h4>
            </div>
            <div class="hot-products">

                @foreach($hotProducts as $hotProduct)

                    <div class="item " >
                        <a href="/weixin/product/{{$hotProduct->id }}"><img src="{{$hotProduct->img }}"></a>
                        <div class="product-name auto-margin">{{$hotProduct->name }}</div>
                        {{--<div class="price-info">--}}
                        {{--<span class="f-left big-font">￥{{$recomProduct->price }}</span>--}}
                        {{--</div>--}}
                    </div>
                @endforeach
            </div>

            <a href="weixin/product/sellCategory/2" class="black-anchor see-all">
                <div >
                    <span class="f-right">查看全部<i class="chevron circle right icon large "></i>
                    </span>
                </div>
            </a>
        </div>

        <!-- 新品-->
        <div class="white-background new-sect">
            <div class="sect-header">

                    <h4>精品套餐
                    </h4>

            </div>

            <div class="combo-products">
                @foreach($newProducts as $newProduct)

                    <div class="item " >
                        <a href="/weixin/product/{{$newProduct->id }}"><img src="{{$newProduct->img }}"></a>
                        <div class="product-name auto-margin">{{$newProduct->name }}</div>
                        {{--<div class="price-info">--}}
                        {{--<span class="f-left big-font">￥{{$recomProduct->price }}</span>--}}
                        {{--</div>--}}
                    </div>
                @endforeach
            </div>
            <a href="weixin/product/sellCategory/3" class="black-anchor see-all">
                <div >
                    <span class="f-right">查看全部<i class="chevron circle right icon large "></i>
                    </span>
                </div>
            </a>
        </div>


        {{--<div class="white-background recommend-sect">--}}
            {{--<div class="recommend-header">--}}
                {{--<h5> <i class="heartbeat icon red"></i>--}}
                    {{--精品促销--}}
                {{--</h5>--}}
            {{--</div>--}}

            {{--<div class="ui equal width center aligned padded grid">--}}
                {{--@foreach($hotProduct as $hotpro)--}}
                    {{--<div class="row">--}}

                        {{--@foreach($hotpro as $product)--}}
                            {{--<div class="column" id="touchArea">--}}
                                {{--<div class="ui segment">--}}
                                    {{--<a href="/weixin/product/{{$product->id}}"><img src="{{$product->img}}" class="product-img-wAh"></a>--}}
                                    {{--<div>{{$product->name}}</div>--}}
                                    {{--<div class="price-info">--}}
                                        {{--<p class="text-algin big-font">￥{{$product->price}}</p>--}}
                                        {{--<!-- <span class="f-left big-font">￥{{$product->price}}</span> -->--}}
                                        {{--<!-- <i class="plus red icon circle big f-right addcart" onclick="Tomenu({{$product->id}})"></i> -->--}}

                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--@endforeach--}}

                    {{--</div>--}}

                {{--@endforeach--}}

            {{--</div>--}}

        {{--</div>--}}








        <div class="ui modal">

            <div class="image content">

                <div class="description menu-box-width">
                    <div class="f-left width-3 text-algin">
                        <a class="menu-icon-big"  href="javascript::void(0)">
                            <i class="add to cart icon  icon"></i>
                        </a>
                    </div>
                    <div class="width-3 f-left text-algin">
                        <a class="menu-icon-big"  href="javascript::void(0)">
                            <i class="heart icon"></i>
                        </a>
                    </div>
                    <div class="f-right width-3 text-algin">
                        <a class="menu-icon-big"  href="javascript::void(0)">
                            <i class="share icon"></i>
                        </a>
                    </div>
                </div>
            </div>

        </div>



        {{--<div class="ui five column grid  " >--}}
        {{--<div class="column nav-menu" >--}}
        {{--<a >--}}
        {{--<div><i class="home icon big"></i></div>--}}
        {{--<p >凡悦</p>--}}
        {{--</a>--}}
        {{--</div>--}}
        {{--<div class="column nav-menu"  >--}}

        {{--<a >--}}
        {{--<div><i class="gift icon big" ></i></div>--}}
        {{--<p>订单中心</p>--}}
        {{--</a >--}}
        {{--</div>--}}
        {{--<div class="column nav-menu">--}}
        {{--<a href="weixin/member">--}}
        {{--<div><i class="user icon big"></i></div>--}}
        {{--<p >个人中心</p>--}}
        {{--</a>--}}
        {{--</div>--}}
        {{--<div class="column nav-menu">--}}
        {{--<a href="weixin/member">--}}
        {{--<div><i class="add to cart icon big"></i></div>--}}
        {{--<p >购物车</p>--}}
        {{--</a>--}}
        {{--</div>--}}
        {{--</div>--}}

    </div>


    <div class="tech-support">技术支持:勤儿行之科技</div>
    <div class="copy-right auto-margin small-font">Copyright©2012-2016 finespace.com All Rights Reserved.闽ICP备12032325号-1</div>

    {{--<div class="slogan">--}}
    {{--<p class="huge-font">凡之悦 Fine space</p>--}}
    {{--</div>--}}



@stop

@section('script')
    <script type="text/javascript">



        function Tomenu(id) {
            $('.ui.modal').modal('show');
            // $(".ui.modal").parent(".dimmer").css('background-color' , "rgba(0,0,0,0)");
        }


        $(window).load(function(){
            $('.owl-carousel').owlCarousel({
                loop:true,
                responsiveClass:true,
                autoplay:true,
                autoplayTimeout:2000,
                autoHeight:true,

                responsive:{
                    0:{
                        items:1,

                        loop:true
                    },
                    600:{
                        items:1,

                        loop:true
                    },
                    1000:{
                        items:1,

                        loop:false
                    }
                }
            })
        })

        $(document).ready(function(){
            $('.product-cate div').click(function(){

                if(!$(this).hasClass('active'))
                {
                    $(this).addClass('active');
                    $(this).siblings('div').removeClass('active');
                }
                if($(this).hasClass('cake'))
                {
                    $('#cake').slideToggle().siblings('.product-sub-cate').hide();
                }
                if($(this).hasClass('coffee'))
                {
                    $('#coffee').slideToggle().siblings('.product-sub-cate').hide();
                }
                if($(this).hasClass('combo'))
                {
                    $('#combo').slideToggle().siblings('.product-sub-cate').hide();
                }

            })

        })


    </script>
@stop