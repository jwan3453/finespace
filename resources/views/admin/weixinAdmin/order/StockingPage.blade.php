@extends('admin.adminMaster')




@section('resources')

@stop

@section('content')
<div class="f-left right-side-panel">

    <div class="breadcrumb-nav">
        <div class="ui  large breadcrumb">
            <a class="section">主页</a> <i class="right angle icon divider"></i>
            <a class="section">订单备货</a>
        </div>
    </div>

    <div class="order-table">

        <table class="ui primary striped selectable table " id="orderTable">
            <thead>
                <tr>
                    <th>订单ID</th>
                    <th>订单号</th>
                    <th>用户</th>
                    <th>总额</th>
                    
                    <th>下单日期</th>
                    <th>取单日期</th>
                    <th>订单详情</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td>{{$order->id}}</td>
                    <td>{{$order->order_no}}</td>
                    <td>{{$order->user_id}}</td>
                    <td>{{$order->total_amount}}</td>
                    
                    <td>{{$order->created_at}}</td>
                    <td>{{$order->order_dateTime}}</td>
                    <td>
                        <a href="{{url('/weixin/admin/order/').'/'.$order->order_no}}" class="ui basic  button ">详情</a>
                    </td>
                </tr>
                @endforeach
              
            </tbody>
        </table>

    </div>

</div>
@stop

@section('script')
<script type="text/javascript"></script>
@stop