@extends('weixinsite')

@section('content')




    <div class="ui  container " >
        <div class="order-detail-box">
            <div class="ui horizontal divider header .huge-font">订单详情</div>
            <div class="order-line-detail">
                订单号：<span class="f-right">{{$orderDetail['order']->order_no}}</span>
            </div>
            <div class="order-line-detail">
                下单时间：<span class="f-right">{{$orderDetail['order']->created_at}}</span>
            </div>



            <div class="order-line-detail">
                订单状态：<span class="f-right">
                                @if($orderDetail['order']->status == 0)
                        取消
                    @elseif($orderDetail['order']->status == 1 &&$orderDetail['order']->pay_status==0 )
                        未支付
                    @elseif($orderDetail['order']->status == 1 &&$orderDetail['order']->pay_status==1 &&$orderDetail['order']->shipping_status==0 )
                        已支付(未发货)
                    @endif
                                </span>
            </div>
            <div class="order-line-detail">
                支付方式：<span class="f-right pay-method">
                    @if($orderDetail['order']->payment_id == 1)
                        支付宝
                    @elseif($orderDetail['order']->payment_id == 2 )
                        微信支付
                    @elseif($orderDetail['order']->payment_id == 3 )
                        账户余额
                    @elseif($orderDetail['order']->payment_id == 4 )
                        豁达付款
                    @endif
                                </span>
            </div>

            @if($orderDetail['order']->shipping_id != 1)
                <div class="order-line-detail">
                    收货人：<span class="f-right">撸阿鲁</span>
                </div>
                <div class="order-line-detail">
                    电话：<span class="f-right">18250922355</span>
                </div>

                <div class="order-line-detail">
                    地址：<span class="f-right">福建省厦门市思明区947号官邸大厦B栋628</span>
                </div>

                <div class="order-line-detail">
                    配送：<span class="f-right">{{$orderDetail['order']->created_at}}</span>
                </div>
            @endif


            <div class="order-line-detail">
                配送方式：<span class="f-right">
                    @if($orderDetail['order']->shipping_id == 1)
                        到店提货
                    @elseif($orderDetail['order']->shipping_id == 2 )
                        顺丰
                    @elseif($orderDetail['order']->shipping_id == 3 )
                        圆通
                    @elseif($orderDetail['order']->shipping_id == 4 )
                        中通
                    @endif
                                </span>
            </div>


                <div class="order-line-detail modify-order" style="text-align: center">
                    @if($orderDetail['order']->status != 0)
                        <i class="payment icon large circular"></i>
                        <i class="trash icon large circular"></i>
                    @endif

                </div>


            @foreach($orderDetail['orderItems'] as $orderItem)
                @if( isset($orderItem->product) )
                    <div class="cart-item">
                        <img class="f-left" src ='{{$orderItem->product->thumb}}'>
                        <div class="name ">{{$orderItem->product->name}}   </div>
                        <div class="type">
                            ￥<span class="unit-price">{{$orderItem->product->price}} x {{$orderItem->count}}</span>

                        </div>

                        <div class="order-date-time ui left icon  fluid input ">
                            <i class=" calendar icon "></i>
                            @if($orderItem->product->type !=2)
                                <input type="text" disabled class="order-datetime"  id="orderDatetime_{{$orderItem->product->id}}" placeholder="取货时间" value="取货时间: {{$orderItem->order_dateTime}}"/>
                            @else
                                <input type="text" disabled class="order-datetime"  id="orderDatetime_{{$orderItem->product->id}}" placeholder="用餐时间" value="用餐时间: {{$orderItem->order_dateTime}}"/>
                            @endif
                        </div>

                        <select class="ui fluid dropdown select-store " disabled>


                            @if($orderItem->product->type !=2)
                                选择取货门店
                            @else
                                选择就餐门店
                            @endif
                            @foreach($orderDetail['orderItems']['store']  as $store)
                                @if($store->id === $orderItem->selected_store)
                                    <option value="{{$store->id}}" selected>{{$store->name}}</option>
                                @else
                                    <option value="{{$store->id}}" >{{$store->name}}</option>
                                @endif
                            @endforeach

                        </select>


                        @if($orderItem['2']['count']>0)
                            <div class="sub-product">
                                餐具(￥5) x  {{$orderItem['2']['count']}}
                                <span class="sub-price f-right">￥{{sprintf("%.2f", $orderItem['2']['totalAmount'] ) }}</span>
                            </div>
                        @endif
                        @if($orderItem['3']['count']>0)
                            <div class="sub-product ">
                                蜡烛(￥5) x {{$orderItem['3']['count']}}
                                <span class="sub-price f-right">￥{{sprintf("%.2f", $orderItem['3']['totalAmount']  )}}</span>
                            </div>
                        @endif
                        <div class="total-product-price">
                            总计:
                            <span class="sub-price f-right huge-font">￥{{ sprintf("%.2f", $orderItem->totalAmount)}}</span>

                        </div>
                    </div>
                @endif
            @endforeach
            {{--<div class="order-total-amount huge-font" >订单总额:￥{{ sprintf("%.2f", $orderDetail['orderItems']['totalOrderAmount'])}}</div>--}}
        </div>



        <div class="qr-code-image">
            {!!  \SimpleSoftwareIO\QrCode\Facades\QrCode::size(250)->generate(url('http://192.168.1.119/weixin/admin/checkOrder/'.$orderDetail['order']->order_no)); !!}
            <p>扫描二维码获取订单详情</p>
        </div>

        <div class="pos-spacing ">
        </div>
        <div class="check-out-box stick-btom">
            订单总额: <span >:￥{{ sprintf("%.2f", $orderDetail['orderItems']['totalOrderAmount'])}}</span>
            <a  class="confirm-btn f-right"><div>支付</div></a>
        </div>
    </div>

    <div class="ui page dimmer modify-order-box">

        {{--<div  class=" modify-actions ">--}}

            {{--<div class="three fluid ui inverted buttons">--}}
                {{--@if($orderDetail['order']->shipping_id != 1)--}}

                {{--<div class="ui red basic inverted button modify-recipient">--}}
                    {{--联系人--}}
                {{--</div>--}}
                {{--<div class="ui green basic inverted button modify-addr">--}}

                    {{--地址--}}
                {{--</div>--}}
                {{--@endif--}}
                {{--<div class="ui red basic inverted button modify-pay">--}}

                    {{--修改支付方--}}
                {{--</div>--}}

            {{--</div>--}}

        {{--</div>--}}


        <div class="new-recipient animate-panel">

            <div class="input-line">
                <div class="ui small labeled input full-input ">
                    <div class="input-label width-20">联系人 </div>
                    <input  class="transparent-input" type="text"  placeholder="">
                </div>
            </div>

            <div class="input-line">
                <div class="ui small labeled input full-input ">
                    <div class="input-label width-20">电话 </div>
                    <input class="transparent-input" type="text" placeholder="">
                </div>
            </div>


        </div>

        <div class="new-delivery-addr animate-panel auto-margin">

                <div class="input-line">
                    <div class="ui small labeled input half-input f-left">
                        <div class="input-label  width-40">省份 </div>
                        <input class="transparent-input" type="text " value="福建" />
                    </div>

                    <div class="ui small labeled input half-input f-right">
                        <div class="input-label width-40">城市 </div>
                        <input class="transparent-input" type="text" value="厦门"/>
                    </div>
                </div>

                <div class="input-line">
                    <div class="ui small labeled input full-input ">
                        <div class="input-label width-20">城市 </div>
                        <input  class="transparent-input" type="text"value="官邸大厦"/>
                    </div>
                </div>



            </div>

        <div class="new-pay-options animate-panel  ">
            <h3>修改支付方式</h3>
            <div class=" vertical fluid ui  inverted buttons">
                <div class="ui red basic inverted button new-pay-method ">
                    1 支付宝
                </div>
                <div class="ui red basic inverted button new-pay-method">
                    2 微信
                </div>
                <div class="ui red basic inverted button new-pay-method">
                    3 账户余额
                </div>
                <div class="ui red basic inverted button new-pay-method">
                    4 货到付款
                </div>
            </div>
            <br/>
            <div class="regular-btn red-btn auto-margin cancel-modify">
                取消
            </div>
        </div>


        {{--<div class="choose-btns">--}}
            {{--<div class="ui  inverted basic  button  auto-margin cancel-modify" style="margin-top:20px"  >--}}
                {{--<i class="remove icon"></i>取消--}}
            {{--</div>--}}

        {{--</div>--}}




        <div class="change-order-status animate-panel">


            <form action="/weixin/cancelOrder" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="orderNo" value="{{$orderDetail['order']->order_no}}">


            <h3>是否确定取消订单</h3>

            <div class="ui buttons dimmer-btn big-font  "  >
                <div class="regular-btn blue-btn cancel-modify"  >取消</div>
                <a class="or" data-text="-"></a>
                <button class="regular-btn red-btn  confirm-delete-order" style="border:0;">
                    确定
                </button>
            </div>
            </form>
        </div>



    </div>


@stop


@section('script')
    <script type="text/javascript">
        $(document).ready(function(){
            $('.new-pay-options').hide();
            $('.new-recipient').hide();
            $('.choose-btns').hide();
            $('.change-order-status').hide();
            $(' .select-store').dropdown();
            $('.payment').click(function(){

                $('.new-pay-options ').siblings('div').hide();
                $('.new-pay-options ').show();

                $('.ui.page.dimmer')
                        .dimmer('show')
                ;
            })

            $('.trash').click(function(){

                $('.change-order-status').siblings('div').hide();
                $('.change-order-status').show();

                $('.ui.page.dimmer')
                        .dimmer('show')
                ;
            })
//
//            $('.modify-pay').click(function(){
//                $('.modify-actions').transition(
//                        {
//                            animation:'fly left',
//                            duration:100,
//                            onComplete: function () {
//                                $('.new-pay-options,.choose-btns').transition('fly right')
//                            }
//                        });
//
//            })
//            $('.modify-addr').click(function(){
//                $('.modify-actions').transition(
//                        {
//                            animation:'fly left',
//                            duration:100,
//                            onComplete: function () {
//                                $('.new-delivery-addr,.choose-btns').transition('fly right')
//                            }
//                        });
//            })
//
//
//            $('.modify-recipient').click(function(){
//                $('.modify-actions').transition(
//                        {
//                            animation:'fly left',
//                            duration:100,
//                            onComplete: function () {
//                                $('.new-recipient,.choose-btns').transition('fly right')
//                            }
//                        });
//            })

            $('.cancel-modify').click(function(){
//                var visibleObj;// = obj;
//                $(this).parent().siblings('.animate-panel').each(function(){
//                  if($(this).css('display') !== 'none')
//                  {
//                      visibleObj = $(this);
//                  }
//
//                });
//
//
//                $('.choose-btns').transition(
//                        {
//                            animation:'fly left',
//                            duration:100,
//                            onComplete: function () {
//                                $('.modify-actions').transition('fly right')
//                            }
//                        });
//                visibleObj.transition('fly left');
                $('.ui.page.dimmer')
                        .dimmer('hide')
                ;
            })
            $('.new-pay-method').click(function(){
                var payIndex= $(this).index();
                $.ajax({
                    type: 'POST',
                    async : false,
                    url: '/weixin/updatePaymentMethod',
                    dataType: 'json',
                    data:{orderNo:'{{$orderDetail['order']->order_no}}',paymentMethod:payIndex+1},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success: function(data)
                    {
                        var status  = data.statusCode;
                        //返回1说明更新成功

                        $('.cancel-modify').click();
                        $('.ui.page.dimmer').dimmer('hide');
                        $('.toaster').text(data.statusMsg).fadeIn(1000).fadeOut(1000);
                        if(status===1)
                        {
                            var newPaymentMethod = '';
                            if(payIndex=== 0)
                                newPaymentMethod = '支付宝';
                            if(payIndex === 1)
                                newPaymentMethod = '微信支付';
                            if(payIndex === 2)
                                newPaymentMethod = '账户余额';
                            if(payIndex === 3)
                                newPaymentMethod = '货到付款';

                            $('.pay-method').text(newPaymentMethod);
                        }



                    },
                    error: function(xhr, type){
                        alert('Ajax error!')
                    }

                });

            })

            $('.confirm-delete-order').click(function(){

            })
        })
    </script>
@stop
