@extends('weixinsite')

@section('content')

    <div class=" ui container " >

        @foreach($orders as $order)
            <div class="order-detail-box">
                <div class="ui horizontal divider header .huge-font">订单号:{{$order->order_no}}
                </div>
                <div class="order-line-detail">
                    下单时间：<span class="f-right">{{$order->created_at}}</span>
                </div>
                <div class="order-line-detail">
                    订单状态：<span class="f-right">
                                @if($order->status == 0)
                            取消
                        @elseif($order->status == 1 &&$order->pay_status==0 )
                            未支付
                        @elseif($order->status == 1 &&$order->pay_status==1 &&$order->shipping_status==0 )
                            已支付(未发货)
                        @endif
                                </span>
                </div>
                <div class="order-line-detail">
                    订单总额：<span class="f-right giant-font total-amount">￥{{$order->total_amount}}</span>
                </div>

                @foreach($order->orderItems as $orderItem)
                    @if($orderItem->parent_product_id == 0)
                    <div class="cart-item">
                        <img class="f-left" src ='{{$orderItem->product->img}}'>
                        <div class="name ">{{$orderItem->product->name}}   </div>
                        <div class="type">
                            1.0磅 X 1
                        </div>


                    </div>
                    @endif
                @endforeach


                    <a href="{{url('/weixin/order')}}/{{$order->order_no}}" >
                        <div class="regular-btn auto-margin" >订单详情</div>
                    </a>

            </div>
            <div class="pos-spacing ">
            </div>
        @endforeach
    </div>
@stop


@section('script')
    <script type="text/javascript">
        $(document).ready(function(){


        })
    </script>

@stop