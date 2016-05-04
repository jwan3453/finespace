@extends('weixinsite')

@section('resources')

@stop

@section('content')

    <div class=" ui container confirm-order-box">

    <form  id="orderCommit" method="post">
        {{ csrf_field() }}
        {{--<div class="order-detail-box">--}}
            {{--<div class="ui horizontal divider header">收货地址</div>--}}


            {{--<div class="ui three column grid top attached tabular menu">--}}
                {{--<a class="item column active tab-menu" data-tab="first">地址</a>--}}
                {{--<a class="item column tab-menu" data-tab="second">收件人</a>--}}
                {{--<a class="item  column tab-menu" data-tab="third">配送时间</a>--}}
            {{--</div>--}}

            {{--<div class="ui bottom attached tab  menu-content active" data-tab="first">--}}


                {{--<div class="btn-section auto-margin">--}}
                    {{--<div class="f-left or-btn active-btn default-addr" >默认地址</div>--}}
                    {{--<div  class="f-right or-btn new-addr">新地址</div>--}}
                {{--</div>--}}


                {{--<div class="delivery-addr">--}}

                    {{--<div>--}}
                        {{--<div class=" addres-icon f-left"><i class="large shipping  icon "></i></div>--}}
                        {{--<div class=" address f-left">送货地址:福建省厦门市思明区XXXXXXXXX</div>--}}
                    {{--</div>--}}
                    {{--<div>--}}
                        {{--<div class="f-left name">收货人:撸啊撸</div>--}}
                        {{--<div class="f-right phone">1800000001</div>--}}
                    {{--</div>--}}
                {{--</div>--}}

                {{--<div class="new-delivery-addr auto-margin">--}}

                    {{--<div class="input-line">--}}
                        {{--<div class="ui small labeled input full-input ">--}}
                            {{--<div class="input-label width-20">联系人 </div>--}}
                            {{--<input type="text" placeholder="">--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="input-line">--}}
                        {{--<div class="ui small labeled input full-input ">--}}
                            {{--<div class="input-label width-20">电话 </div>--}}
                            {{--<input type="text" placeholder="">--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="input-line">--}}
                        {{--<div class="ui small labeled input half-input f-left">--}}
                            {{--<div class="input-label  width-40">省份 </div>--}}
                            {{--<input type="text" placeholder="福建">--}}
                        {{--</div>--}}

                        {{--<div class="ui small labeled input half-input f-right">--}}
                            {{--<div class="input-label width-40">城市 </div>--}}
                            {{--<input type="text" placeholder="厦门">--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="input-line">--}}
                        {{--<div class="ui small labeled input full-input ">--}}
                            {{--<div class="input-label width-20">城市 </div>--}}
                            {{--<input type="text" placeholder="">--}}
                        {{--</div>--}}
                    {{--</div>--}}


                {{--</div>--}}


            {{--</div>--}}
            {{--<div class="ui bottom attached tab segment" data-tab="second">Second </div>--}}
            {{--<div class="ui bottom attached tab   menu-content" data-tab="third">--}}
                {{--<div class="delivery-time">--}}


                    {{--<div class="input-line">--}}
                        {{--<div class="ui small labeled input full-input ">--}}
                            {{--<div class="input-label width-20">日期 </div>--}}
                            {{--<input type="text" data-field="date" readonly>--}}
                        {{--</div>--}}
                    {{--</div>--}}


                    {{--<div class="input-line">--}}
                        {{--<div class="ui small labeled input full-input ">--}}
                            {{--<div class="input-label width-20">时间 </div>--}}
                            {{--<input type="text" data-field="time" readonly>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    {{--<div id="dtBox"></div>--}}

                {{--</div>--}}




            {{--</div>--}}
        {{--</div>--}}

        <div class="order-detail-box">
            <div class="ui horizontal divider header">
                商品清单
            </div>

            @foreach($cartItems as $cartItem)
                @if( isset($cartItem->product) )
                <div class="cart-item">
                    <img class="f-left" src ='{{$cartItem->product->thumb}}'>
                    <div class="name ">{{$cartItem->product->name}}   </div>
                    <div class="type">
                        ￥<span class="unit-price">{{$cartItem->product->price}} x {{$cartItem->count}}</span>

                    </div>

                    <div class="order-date-time ui left icon  fluid input ">
                        <i class=" calendar icon "></i>

                        @if($cartItem->product->type != 2)
                            <input type="text" disabled class="order-datetime"  id="orderDatetime_{{$cartItem->product->id}}" placeholder="取货时间" value="取货时间: {{$cartItem->order_dateTime}}"/>
                        @else
                            <input type="text" disabled class="order-datetime"  id="orderDatetime_{{$cartItem->product->id}}" placeholder="用餐时间" value="用餐时间: {{$cartItem->order_dateTime}}"/>
                        @endif

                    </div>

                    <select class="ui fluid dropdown select-store " disabled>

                        @if($cartItem->product->type != 2)
                            选择取货门店
                        @else
                            选择就餐门店
                        @endif
                        @foreach($cartItems['store']  as $store)
                            @if($store->id === $cartItem->selected_store)
                                <option value="{{$store->id}}" selected>{{$store->name}}</option>
                            @else
                                <option value="{{$store->id}}" >{{$store->name}}</option>
                            @endif
                        @endforeach

                    </select>

                    @if($cartItem['2']['count']>0)
                        <div class="sub-product">
                            餐具(￥5) x  {{$cartItem['2']['count']}}
                            <span class="sub-price f-right">￥{{sprintf("%.2f", $cartItem['2']['totalAmount'] ) }}</span>
                        </div>
                    @endif
                    @if($cartItem['3']['count']>0)
                        <div class="sub-product ">
                            蜡烛(￥5) x {{$cartItem['3']['count']}}
                            <span class="sub-price f-right">￥{{sprintf("%.2f", $cartItem['3']['totalAmount']  )}}</span>
                        </div>
                    @endif
                    <div class="total-product-price">
                        总计:
                        <span class="sub-price f-right huge-font">￥{{ sprintf("%.2f", $cartItem->totalAmount)}}</span>

                    </div>
                </div>
                @endif
            @endforeach
            <div class="order-total-amount huge-font" >订单总额:￥{{ sprintf("%.2f", $cartItems['totalOrderAmount'])}}</div>


        </div>


        <div class="order-detail-box">
            <div class="ui horizontal divider header">支付方式</div>
            <ul class="vertical-list-menu pay-list-menu" >
                <li class="menu-item weixin-pay"  >
                    <div class="f-left menu-icon" ><div class="weixin-pay-icon"></div></div>
                    <div class="big-font f-left menu-text">微信支付</div>
                    <div class="f-right menu-icon"><i class="checkmark box icon large transition hidden"></i></div>
                </li>
                <li class=" menu-item ali-pay"  >
                    <div class="f-left menu-icon" ><div class="ali-pay-icon "></div></div>
                    <div class="big-font f-left menu-text">支付宝支付</div>
                    <div class="f-right menu-icon"><i class="checkmark box icon large transition hidden"></i></div>
                </li>
                <li class=" menu-item account-cash"  >
                    <div class="f-left menu-icon" ><i class="user large  icon "></i></div>
                    <div class="big-font f-left menu-text">账户余额</div>
                    <div class="f-right menu-icon"><i class="checkmark box icon large transition hidden"></i></div>
                </li>
                <li class=" menu-item "  >
                    <div class="f-left menu-icon" ><i class="money large  icon "></i></div>
                    <div class="big-font f-left menu-text">货到付款</div>
                    <div class="f-right menu-icon"><i class="checkmark box icon large transition hidden"></i></div>
                </li>

            </ul>

        </div>
        <input type="hidden" value="0" id="payMethod" name="payMethod" />
        <input type="hidden" value="1" id="deliveryAddr" name="deliveryAddr"/>
        <div class="pos-spacing">
        </div>

        <div class="stick-btom ">
            <a  class="back-btn f-left" href="/weixin/cart"><i class="  arrow left large  circle icon  "></i>返回购物车</a>
            <a  class="confirm-btn f-right" ><div>确定订单</div></a>
        </div>

    </form>

    <div class="loader-box none-display ">
        <div class="ui active centered large inline loader   "></div>
    </div>
    </div>


@stop


@section('script')
    <script type="text/javascript">
        $(document).ready(function(){


            $(' .select-store').dropdown();

            $('.stick-btom').css('width',$('.confirm-order-box').width());

            $('.menu .item')
                    .tab()
            ;

            $('.or-btn').click(function(){

                var btn = $(this);
                btn.addClass('active-btn');
                btn.siblings('.or-btn').removeClass('active-btn');

                if(btn.hasClass('default-addr'))
                {

                    if($('.delivery-addr').css('display') === 'none')
                    {

                        $('.delivery-addr')  .transition({
                            animation: 'horizontal flip',
                            duration: '0.3s',
                            onStart: function () {
                                $('.new-delivery-addr').hide();
                            }
                        });

                    }
                }
                else{

                    if($('.new-delivery-addr').css('display') === 'none')
                    {




                        $('.delivery-addr')  .transition({
                            animation: 'horizontal flip',
                            duration: '0.3s',
                            onComplete: function () {
                                $('.new-delivery-addr').fadeIn();
                            }
                        });

                    }
                }

            })


            $('.menu-item').click(function(){

                var checkmark = $(this).find('.checkmark');
                if(checkmark.css('display') === 'none')
                {
                    checkmark.transition('fly right');
                    checkmark.parents('li').siblings('.menu-item').find('.checkmark').each(function(){
                        if($(this).css('display')!=='none')
                        {
                            $(this).transition('fly left');
                        }
                    })
                }
                //支付方式
                if($(this).hasClass('weixin-pay'))
                {
                    $('#payMethod').val(1);
                }
                else if($(this).hasClass('ali-pay')){
                    $('#payMethod').val(2);
                }
                else if($(this).hasClass('account-cash')){
                    $('#payMethod').val(3);
                }
                else {
                    $('#payMethod').val(4);
                }
            })


            $('.confirm-btn ').click(function(){


                    $('.loader-box').removeClass('none-display');
//                    $('.dimmer').dimmer({
//
//                        duration: {
//                            show : 1000,
//                            hide:1000
//                        }
//                }).dimmer('show');
//                alert($('.dimmer')
//                        .dimmer('get duration'));
//                ;


                $.ajax({
                    type: 'POST',

                    url: '/weixin/generateOrder',
                    sync:false,
                    dataType: 'json',
                    data : $('#orderCommit').serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success: function(data)
                    {
                        var status  = data.statusCode;

                        if(status === 1 ) {
                            $('.loader-box').addClass('none-display');
                            location.href = '{{url('weixin/order')}}'+'/'+data.extra;
//                            $('.dimmer').dimmer({
//
//                                duration: {
//                                    show : 1000,
//                                    hide:1000
//                                }
//                            }).dimmer('hide');

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