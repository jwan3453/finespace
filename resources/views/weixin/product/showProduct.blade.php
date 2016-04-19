@extends('weixinsite')



@section('resources')

    <script src={{ asset('js/swiper/owl.carousel.min.js') }}></script>
    <link rel="stylesheet" type="text/css" href= {{ asset('js/swiper/owl.carousel.min.css') }}>
    <link rel="stylesheet" type="text/css" href= {{ asset('js/swiper/owl.theme.default.min.css') }}>




@stop




@section('content')

    <div class=" ui container prod-detail-box"  >


        <div >
            <div class="owl-carousel owl-theme">
                @foreach($product->img as $img)

                <div class="item" > <img style="width:100%;" src = {{$img}}></div>
                @endforeach
            </div>
        </div>
        <div class="prod-spec">
            <div class="giant-font name">{{$product->name}}</div>
            <div class=" extra ">

                <div class="product-tag">
                    @foreach($product->keywords as $keyword)

                    <div >
                        {{$keyword}}
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="price giant-font">￥<span id="unitPrice">{{$product->price}}</span></div>

            <div class="specs specs-level2 ">
                @foreach( $product->spec as $spec)
                    @if($spec['level'] == 2)
                        <div class="ui big-font  tag label"><i class="selected radio icon" ></i>{{$spec['content']['name']}}:{{$spec['content']['value']}}</div>
                    @endif
                @endforeach
            </div>
            <div class="specs">
                @foreach( $product->spec as $spec)
                    @if($spec['level'] == 1)
                        <div>
                            {{$spec['content']['name']}}:


                            @if(is_numeric($spec['content']['value']))
                                <div class="ui rating" data-rating="{{ $spec['content']['value']}}" data-max-rating="5"></div>
                                @else
                                {{$spec['content']['value']}}
                            @endif

                        </div>


                    @endif
                @endforeach
            </div>




        </div>


        <div class="pos-spacing"></div>
        <div class="pos-spacing"></div>
        <div class="prod-price">
            <i class=" f-left minus large  icon teal icon-count "></i>
            <input class="f-left  big-font quantity" type="text"  value="1"/>
            <i class="f-left  plus large icon red  icon-count"></i>
            <div class="f-right  total-price">
                总计:<strong class="huge-font">￥<span id="totalPrice">{{$product->price}}</span></strong>
            </div>
        </div>

        <div class="add-to-cart giant-font">
            加入购物车
        </div>


    </div>

    <div class="ui page dimmer">
        <div class="  dimmer-box" >
            <h3>已经加入了购物车</h3>

            <div class="ui buttons dimmer-btn "   >
                <button type="submit" class="ui teal button" >继续购物</button>
                <a class="or" data-text="<->"></a>
                <a class="ui teal  button" href="/weixin/cart" >购物车</a>
            </div>
        </div>
    </div>
@stop


@section('script')
    <script type="text/javascript">


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
                        items:3,

                        loop:false
                    }
                }
            })
        })



        $(document).ready(function(){


            var unitPrice = parseInt($('#unitPrice').text());

            $('.add-to-cart,.prod-price').css('width',$('.prod-detail-box').width());

            //评级系统
            $('.ui.rating')
                    .rating({
                        interactive:false,
                        clearable:false
                    })
            ;

            var quantity = $('.quantity');
            $('.plus').click(function(){

                var itemCount =   parseInt(quantity.val());
                quantity.val(itemCount+1);
                var totalPrice = unitPrice * (itemCount+1);
                $('#totalPrice').text(totalPrice);
            })

            $('.minus').click(function(){

                var itemCount =   parseInt($('.quantity').val());
                if(itemCount > 0){
                    $('.quantity').val(itemCount-1);
                    var totalPrice = unitPrice * (itemCount-1);
                    $('#totalPrice').text(totalPrice);
                }
            })

            $('.add-to-cart').click(function (){
                $.ajax({
                    type: 'POST',
                    async : false,
                    url: '/weixin/addToCart',
                    dataType: 'json',
                    data:{productId:'{{$product->id}}',parentProductId:0,quantity:$('.quantity').val()},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success: function(data)
                    {
                        var status  = data.statusCode;
                        var messageCount = $('.icon-message-count');

                        if(status ==1 )
                        {
                            var newitemCount =   parseInt($('.quantity').val());

                            var itemCount = parseInt(messageCount.text());

                            if(itemCount === 0)
                            {
                                messageCount.removeClass('none-display').fadeIn();
                                messageCount.text(itemCount+newitemCount);
                            }
                            else{
                                messageCount.text(itemCount+newitemCount);
                            }

                            $('.dimmer')
                                    .dimmer('show',{closable:'false'})
                            ;
                        }
                        else{
                            alert('失败了');
                        }

                    },
                    error: function(xhr, type){
                        alert('Ajax error!')
                    }

                });
            })

        })
    </script>

@stop