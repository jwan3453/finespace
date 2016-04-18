@extends('weixinsite')


@section('resources')
    <script src={{ asset('js/jquery.fly.min.js') }}></script>
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

        <div class="ui grid">
        <div class="five column row cat_mar">
            <div class="column cat_border" style="text-align: center;">
                <a class="ui label a-width " href="/weixin/CateProList/1"><div class="icon-one"></div> 
                <span class="big-font">布丁</span> </a>
            </div>
            <div class="column cat_border" style="text-align: center;">
                <a class="ui label a-width" href="/weixin/CateProList/2"><div class="icon-two"></div> 
                <span class="big-font">乳脂</span> </a>
            </div>
            <div class="column" style="text-align: center;">
                <a class="ui label a-width" href="/weixin/CateProList/3"><div class="icon-three"></div> 
                <span class="big-font">穆斯</span> </a>
            </div>
            <div class="column" style="text-align: center;">
                <a class="ui label a-width " href="/weixin/CateProList/4"><div class="icon-four"></div> 
                <span class="big-font">巧克力</span>  </a>
            </div>
            <div class="column" style="text-align: center;">
                <a class="ui label a-width" href="/weixin/CateProList/5"><div class="icon-five"></div> 
                <span class="big-font">芝士</span> </a>
            </div>
           
        </div>
        </div>

        <!-- 热门推荐-->
        <div class="white-background recommend-sect">
            <div class="recommend-header">
                <h5><i class="heartbeat icon red"></i>热门推荐</h5>
            </div>

            <div class="ui equal width center aligned padded grid">
                <div class="row">
                    <div class="column item-left " >
                        <a href="/weixin/product/1"><img src="../img/thumb_cake1.jpg"></a>
                        <div >凡悦私享空间</div>
                        <div class="price-info">

                            <span class="f-left big-font">￥123.00</span>
                            <i class="plus red icon circle big f-right addcart"></i>

                        </div>
                    </div>
                    <div class="column item-right ">
                        <img src="../img/thumb_cake1.jpg">
                        <div>卡布奇诺</div>
                        <div class="price-info">

                            <span class="f-left big-font">￥21.00</span>
                            <i class="plus red icon circle big f-right addcart"></i>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="column item-left " >
                        <img src="../img/thumb_cake1.jpg">
                        <div >凡悦私享空间</div>
                        <div class="price-info">

                            <span class="f-left big-font">￥123.00</span>
                            <i class="plus red icon circle big f-right addcart"></i>

                        </div>
                    </div>
                    <div class="column item-right ">
                        <img src="../img/thumb_cake1.jpg">
                        <div>卡布奇诺</div>
                        <div class="price-info">

                            <span class="f-left big-font">￥21.00</span>
                            <i class="plus red icon circle big f-right addcart"></i>

                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="white-background recommend-sect">
            <div class="recommend-header">
                <h5> <i class="heartbeat icon red"></i>
                    精品促销
                </h5>
            </div>

            <div class="ui equal width center aligned padded grid">
                @foreach($hotProduct as $hotpro)
                <div class="row">

                    @foreach($hotpro as $product)
                    <div class="column" id="touchArea">
                        <div class="ui segment">
                            <img src="{{$product->img}}" class="product-img-wAh">
                        <div>{{$product->name}}</div>
                        <div class="price-info">

                            <span class="f-left big-font">￥{{$product->price}}</span>
                            <!-- <i class="plus red icon circle big f-right addcart"></i> -->

                        </div>
                        </div>
                    </div>
                    @endforeach
                    
                </div>

                @endforeach

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
        <hr/>
    </div>



    {{--<div class="slogan">--}}
    {{--<p class="huge-font">凡之悦 Fine space</p>--}}
    {{--</div>--}}



@stop

@section('script')
    <script type="text/javascript">
        $(document).ready(function(){
            var clickable = true;
            var itemCount = 0;
            var offset = $('#cartIcon').offset();
            $('.owl-carousel').owlCarousel({
                loop:true,
                responsiveClass:true,
                autoplay:true,
                autoplayTimeout:3000,
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
            $('.addcart').click(function(){
                if(clickable == false)
                    return;
                itemCount++;
                var addtoCar = $(this);
                addtoCar.attr("disabled",true);
                var img =  addtoCar.parent().siblings('img').attr('src');
                var flyer = $('<img class="u-flyer" style="width:80px;height:80px;border-radius: 100%;" src="'+img+'">');
                clickable = false;
                flyer.fly({
                    start: {
                        left:0, //开始位置（必填）#fly元素会被设置成position: fixed
                        top: 480 //开始位置（必填）
                    },
                    end: {
                        left: offset.left+10, //结束位置（必填）
                        top: offset.top+10, //结束位置（必填）
                        width: 0, //结束时宽度
                        height: 0 //结束时高度
                    },
                    onEnd: function(){ //结束回调
                        clickable = true;
                        if(itemCount > 0)
                        {
                            $('.icon-message-count').removeClass('none-display').fadeIn();
                            $('.icon-message-count').text(itemCount);
                        }
//                        $("#msg").show().animate({width: '250px'}, 200).fadeOut(1000); //提示信息
//                        addcar.css("cursor","default").removeClass('orange').unbind('click');
//                        this.destory(); //移除dom
                    }
                });
            })
        })
    </script>
@stop