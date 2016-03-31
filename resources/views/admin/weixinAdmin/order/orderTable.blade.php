


<table class="ui primary striped selectable table ">
    <thead>
    <tr>
        <th>订单ID</th>
        <th>订单号</th>
        <th>用户</th>
        <th>总额</th>
        <th>支付方式</th>
        <th>支付状态</th>
        <th>订单状态</th>
        <th>创建日期</th>
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
            <td>{{$order->payment_id}}</td>
            <td>{{$order->pay_status}}</td>
            <td>{{$order->status}}</td>
            <td>{{$order->created_at}}</td>
            <td><a href="{{url('/weixin/admin/order/').'/'.$order->order_no}}" class="ui basic  button ">详情</a></td>
        </tr>

    @endforeach
    <tr>

        <th colspan="2" style="padding:5px;">
            <div class="ui small  teal button">
                订单总额:{{$totalAmount}}
            </div>
            <div class="ui small  teal button">
                总单数:{{count($orders)}}
            </div>
        </th>
        <th></th>
        <th></th>
        <th></th>
        <th colspan="3" style="padding:2px;">
            <div>
                {!! $orders->render() !!}
            </div>
        </th>
        <th></th>
    </tr>

</table>
