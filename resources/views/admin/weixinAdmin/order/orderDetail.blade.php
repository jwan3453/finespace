@extends('admin.adminMaster')




@section('resources')

@stop

@section('content')


    <div class=" right-side-panel">
        <div class="breadcrumb-nav">
            <div class="ui  large breadcrumb">
                <a class="section">主页</a>
                <i class="right angle icon divider"></i>
                <a class="section">订单详情</a>
            </div>
        </div>
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


            @foreach($orderDetail['orderItems'] as $orderItem)
                <div class="cart-item">
                    <img class="f-left" src ='{{$orderItem->product->thumb}}'>
                    <div class="name ">{{$orderItem->product->name}}   </div>
                    <div class="type">
                        1.0磅 X 1
                    </div>
                    <div class="product-price">
                        单价: <span class=" f-right">￥100</span>

                    </div>
                    @if($orderItem->dinnerWareCount>0)
                        <div class="sub-product">
                            餐具(￥5) x  {{$orderItem->dinnerWareCount}}
                            <span class="sub-price f-right">￥20</span>
                        </div>
                    @endif
                    @if($orderItem->candleCount>0)
                        <div class="sub-product ">
                            蜡烛(￥5) x {{$orderItem->candleCount}}
                            <span class="sub-price f-right">￥20</span>
                        </div>
                    @endif
                    <div class="total-product-price">
                        总计:
                        <span class="sub-price f-right huge-font">￥140</span>

                    </div>
                </div>
            @endforeach

        </div>
    </div>
@stop





@section('script')
    <script type="text/javascript">
        $(document).ready(function(){




        })
    </script>
@stop
