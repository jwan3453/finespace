@extends('weixinsite')
<div class="ui  container " >
    <div class="order-detail-box">
        <div class="ui horizontal divider header .huge-font">订单详情</div>
        <div class="order-line-detail">
            订单号：
            <span class="f-right">{{$orderDetail['order']->order_no}}</span>
        </div>
        <div class="order-line-detail">
            下单时间：
            <span class="f-right">{{$orderDetail['order']->created_at}}</span>
        </div>

        <div class="order-line-detail">
            订单状态：
            <span class="f-right">
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
            支付方式：
            <span class="f-right pay-method">
                    @if($orderDetail['order']->payment_id == 1)
                        支付宝
                    @elseif($orderDetail['order']->payment_id == 2 )
                        微信支付
                    @elseif($orderDetail['order']->payment_id == 3 )
                        账户余额
                    @elseif($orderDetail['order']->payment_id == 4 )
                        货到付款
                    @endif
            </span>
        </div>
        @if($orderDetail['order']->shipping_id != 1)
        <div class="order-line-detail">
            收货人：
            <span class="f-right">撸阿鲁</span>
        </div>
        <div class="order-line-detail">
            电话：
            <span class="f-right">18250922355</span>
        </div>

        <div class="order-line-detail">
            地址：
            <span class="f-right">福建省厦门市思明区947号官邸大厦B栋628</span>
        </div>

        <div class="order-line-detail">
            配送：
            <span class="f-right">{{$orderDetail['order']->created_at}}</span>
        </div>
        @endif
        <div class="order-line-detail">
            配送方式：
            <span class="f-right">
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
            @if($orderDetail['order']->status != 0) <i class="payment icon large circular"></i> <i class="trash icon large circular"></i>
            @endif
        </div>
        @foreach($orderDetail['orderItems'] as $orderItem)
                @if( isset($orderItem->product) )
        <div class="cart-item">
            <img class="f-left" src ='{{$orderItem->
            product->thumb}}'>
            <div class="name ">{{$orderItem->product->name}}</div>
            <div class="type">
                ￥
                <span class="unit-price">{{$orderItem->product->price}} x {{$orderItem->count}}</span>

            </div>

            <div class="order-date-time ui left icon  fluid input ">
                <i class=" calendar icon "></i>
                @if($orderItem->product->type !=2)
                <input type="text" disabled class="order-datetime"  id="orderDatetime_{{$orderItem->
                product->id}}" placeholder="取货时间" value="取货时间: {{$orderItem->order_dateTime}}"/>
                            @else
                <input type="text" disabled class="order-datetime"  id="orderDatetime_{{$orderItem->
                product->id}}" placeholder="用餐时间" value="用餐时间: {{$orderItem->order_dateTime}}"/>
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
            {{--
        <div class="order-total-amount huge-font" >
            订单总额:￥{{ sprintf("%.2f", $orderDetail['orderItems']['totalOrderAmount'])}}
        </div>
        --}}
    </div>

    <div class="pos-spacing "></div>
    <div class="check-out-box stick-btom">
        订单总额:
        <span >
            :￥{{ sprintf("%.2f", $orderDetail['orderItems']['totalOrderAmount'])}}
        </span>
       
    </div>
</div>


@section('script')
    <script type="text/javascript">
        $(document).ready(function(){

            $(".home-header").css('display','none');


        })
    </script>
@stop