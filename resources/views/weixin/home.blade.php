
@extends('weixinsite')


@section('resources')
    <script src={{ asset('js/jquery.fly.min.js') }}></script>
@stop

@section('content')






    <div class="ui  container" style=" overflow:hidden;" id="homepage">




        <div class="home-bg">
            <img src="../img/bg5.jpg">
        </div>

        <div class="ui grid">
        <div class="five column row cat_mar">
            <div class="column cat_border" style="text-align: center;">
                <a class="ui label a-width " href="/weixin/Pudding"><div class="icon-one"></div> 
                <span class="big-font">布丁</span> </a>
            </div>
            <div class="column cat_border" style="text-align: center;">
                <a class="ui label a-width"><div class="icon-two"></div> 
                <span class="big-font">乳脂</span> </a>
            </div>
            <div class="column" style="text-align: center;">
                <a class="ui label a-width"><div class="icon-three"></div> 
                <span class="big-font">穆斯</span> </a>
            </div>
            <div class="column" style="text-align: center;">
                <a class="ui label a-width "><div class="icon-four"></div> 
                <span class="big-font">巧克力</span>  </a>
            </div>
            <div class="column" style="text-align: center;">
                <a class="ui label a-width"><div class="icon-five"></div> 
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