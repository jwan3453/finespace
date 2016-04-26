@extends('weixinsite')
@section('resources')

    <script src={{ asset('js/swiper/owl.carousel.min.js') }}></script>
    <link rel="stylesheet" type="text/css" href= {{ asset('js/swiper/owl.carousel.min.css') }}>
    <link rel="stylesheet" type="text/css" href= {{ asset('js/swiper/owl.theme.default.min.css') }}>


    <script src={{ asset('js/dateTime/mobiscroll.custom-2.17.0.min.js') }}></script>
    <link rel="stylesheet" type="text/css" href= {{ asset('js/dateTime/mobiscroll.custom-2.17.0.min.css') }}>

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

        <input type="hidden" id="limitPerday" value="{{$product->limit_per_day}}">

        <div class="prod-spec">
            <div class="giant-font name">{{$product->name}}</div>

            <div class=" extra ">

                <div class="product-tag">

                    @if($product->keywords !='')

                        @foreach($product->keywords as $keyword)

                        <div >
                            {{$keyword}}
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="price giant-font">￥<span id="unitPrice">{{$product->price}}</span></div>

            <div class="order-date-time ui left icon  fluid input huge-font">
                <i class=" calendar icon "></i> <input type="text" class="" id="deliveryDatetime" placeholder="预定时间" />
            </div>

            <select class="ui fluid dropdown select-store huge-font">
                <option value="">选择取货门店</option>
                @foreach($product->store  as $store)
                    <option value="{{$store->id}}">{{$store->name}}</option>
                @endforeach

            </select>

            <div class="  specs-level2 ">
                @foreach( $product->spec as $spec)
                    @if($spec['level'] == 2)
                        <div class="big-font  "><i class="selected radio icon" ></i>{{$spec['content']['name']}}:{{$spec['content']['value']}}</div>
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





            <div class="specs"> {{$product->brief}}</div>
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

        $('#deliveryDatetime').mobiscroll().datetime({
            theme: 'Mobiscroll',     // Specify theme like: theme: 'ios' or omit setting to use default
            display: 'bottom', // Specify display mode like: display: 'bottom' or omit setting to use default
            lang: 'ZH',     // Specify language like: lang: 'pl' or omit setting to use default
                // stepMinute: ,  // More info about stepMinute: http://docs.mobiscroll.com/2-17-0/datetime#!opt-stepMinute

            dateOrder:'ymmdd',
            cancelText:'取消',
            setText:'设置',
            yearText:'年份',
            monthText:'月份',
            dayText:'天',
            hourText:'小时',
            timeWheels:'HH',
            timeFormat:'HH:ii',
            dateFormat:'yy-mm-dd'
        });




        $(document).ready(function(){



            var unitPrice = parseInt($('#unitPrice').text());

            $(' .select-store').dropdown({
                onChange: function(value, text, $selectedItem) {
                    //$('#selectBrand').val(value);
                }
            })


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

                var valid = true;
                {
                    @if(!Auth::check())

                        location.href = '{{url('auth/login')}}';
                        return;

                    @endif
                }


                //是否选择了到店取货时间
                if($('#deliveryDatetime').val() =='' )
                {

                    _showToaster('请选择取货时间');
                    valid=false;
                }
                else
                {

                   var dateTime =new Date($('#deliveryDatetime').val());
                   var hour = dateTime.getHours();
                    //取货时间是否在范围内
                   if( hour < 10 || hour > 22)
                   {
                       _showToaster('门店取货时间 10:00-22:00');
                       valid=false;
                   }
                   else if(parseInt($('#limitPerday').val()) > 0)
                   {
                       //该商品是否限量(套餐)
                       //todo 完善 计算限量剩余逻辑
                       $.ajax({
                           type: 'POST',
                           async : false,
                           url: '/weixin/checkProductLimit',
                           dataType: 'json',
                           data:{
                               productId:'{{$product->id}}',
                               orderDateTime:$('#deliveryDatetime').val()
                           },
                           headers: {
                               'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                           },
                           success: function(data)
                           {
                               var status  = data.statusCode;

                               if(status ==1 )
                               {
                                    if(parseInt(quantity.val()) > parseInt( data.extra))
                                    {
                                        _showToaster('当日可定数量只剩'+data.extra+'套');
                                        valid=false;
                                    }
                               }
                               else{
                                   alert('失败了');
                               }

                           },
                           error: function(xhr, type){
                               alert('Ajax error!')
                           }

                       });

                   }
                   //是否选择了取货门店
                   else if($('.select-store option:selected').val()=='')
                   {
                        _showToaster('请选择预约门店');
                        valid=false;
                   }
                }
                if(valid == true)
                {
                    $.ajax({
                        type: 'POST',
                        async : false,
                        url: '/weixin/addToCart',
                        dataType: 'json',
                        data:{
                                productId:'{{$product->id}}',
                                parentProductId:0,
                                quantity:$('.quantity').val(),
                                orderDateTime:$('#deliveryDatetime').val(),
                                selectedStore:$('.select-store option:selected').val()
                        },
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
                }

            })

        })
    </script>

@stop