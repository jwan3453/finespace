@extends('weixinsite')



@section('resources')

    <script src={{ asset('js/swipe/idangerous.swiper.min.js') }}></script>
    <link rel="stylesheet" type="text/css" href= {{ asset('js/swipe/idangerous.swiper.css') }}>
@stop

@section('content')



        <div class="device">
            <a class="arrow-left" href="#" rel="external nofollow"  rel="external nofollow" ></a>
            <a class="arrow-right" href="#" rel="external nofollow"  rel="external nofollow" ></a>
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <div class="swiper-slide"> <img src="http://7xq9bj.com1.z0.glb.clouddn.com/cake_1.jpg"> </div>
                    <div class="swiper-slide"> <img src="http://7xq9bj.com1.z0.glb.clouddn.com/cake_1.jpg"> </div>
                    <div class="swiper-slide">
                        <div class="content-slide">
                            <p class="title">Slide with HTML</p>
                            <p>在这里放置任意html，例如html文本、视频。</p>
                            <p><a href="http://www.jiawin.com/">觉唯网</a>，推崇以用户为中心的设计理念，致力于为设计爱好者提供一个良好的学习交流平台。</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pagination"></div>
        </div>

@stop


@section('script')
    <script type="text/javascript">


        //初始化swipe插件
        var mySwiper = new Swiper('.swiper-container',{
            pagination: '.pagination',
            loop:true,
            grabCursor: true,
            paginationClickable: true,
            autoplay:1000
        })
        $('.arrow-left').on('click', function(e){
            e.preventDefault()
            mySwiper.swipePrev()
        })
        $('.arrow-right').on('click', function(e){
            e.preventDefault()
            mySwiper.swipeNext()
        })

        $(document).ready(function(){

            $('.add-to-cart,.prod-price').css('width',$('.prod-detail-box').width());

            var quantity = $('.quantity');
            $('.plus').click(function(){

                var itemCount =   parseInt(quantity.val());
                quantity.val(itemCount+1);
//                var itemCount = parseInt($('.icon-message-count').text());
//                itemCount +=1;
//                if(itemCount === 0)
//                {
//                    $('.icon-message-count').removeClass('none-display').fadeIn();
//                    $('.icon-message-count').text(itemCount);
//                }
//                else{
//                    $('.icon-message-count').text(itemCount);
//                }

            })

            $('.minus').click(function(){

                var itemCount =   parseInt(quantity.val());
                if(itemCount >= 0){
                    $('.quantity').val(itemCount-1);
                }
            })



        })
    </script>

@stop