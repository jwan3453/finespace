@extends('admin.adminMaster')




@section('resources')
    <link rel="stylesheet" type="text/css" href= {{ asset('css/jquery-ui.min.css') }}>

    <script src={{ asset('js/jquery-ui.min.js') }}></script>
@stop

@section('content')


    <div class="f-left right-side-panel">


        <div class="breadcrumb-nav">
            <div class="ui  large breadcrumb">
                <a class="section">主页</a>
                <i class="right angle icon divider"></i>
                <a class="section">订单管理</a>
            </div>
        </div>



        <div class="order-table">
            <form method="get" action="/weixin/admin/order/seachOrder">
                <div class="ui icon input search-bar">
                    从<input type="text" class="from" id="from" name="from" placeholder="起始时间">
                    到<input type="text" class="to" id="to" name="to" placeholder="结束时间">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="text" placeholder="请输入单号..." id="seachData" name="seachData" value="{{$seachData}}">
                    <!-- <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"> -->
                    <button class="ui circular search link icon button submit-btn" type="submit">
                    <!-- <i class="chevron circle left icon"></i> -->
                        <i class="search link icon"></i>
                    </button>
                </div>
            </form>



            @if(count($orders)>0)
                @include('admin.weixinAdmin.order.orderTable')
            @endif
            {{--<div class="table-content">--}}

                {{--<a class="f-right ui button primary" href="{{url('/weixin/admin/product/add')}}">添加商品</a>--}}
            {{--</div>--}}
        </div>

    </div>



@stop

@section('script')
    <script type="text/javascript">
        $(document).ready(function(){
            $( "#from" ).datepicker({
                dateFormat: 'yy-mm-dd',
                showButtonPanel:true,
                changeMonth: true,
                numberOfMonths: 1,

                onClose: function( selectedDate ) {
                    $( "#to" ).datepicker( "option", "minDate", selectedDate );
                  }
                });
            $( "#to" ).datepicker({
                dateFormat: 'yy-mm-dd',
                showButtonPanel:true,
                changeMonth: true,
                numberOfMonths:1,
                onClose: function( selectedDate ) {
                    $( "#from" ).datepicker( "option", "maxDate", selectedDate );
                }
            });

            $.datepicker.formatDate('dd-mm-yy');

        })

        $("#ToSeach").click(function(){

            var seachData = $("#seachData").val();
            var formdate = $("#from").val();
            var todate = $("#to").val();


            $.ajax({
                type: 'POST',
                url: '/weixin/admin/order/seachOrder',
                data: {seachData : seachData},
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success: function(data){
                    $("#orderTable tbody").html("");
                    var a = '';
                    if (data.length > 0) {
                        for (var i = 0; i < data.length; i++) {
                            // console.log(data[i]);
                            var tr = '';
                            tr += "<tr>";
                            tr += "<td>"+data[i].id+"</td>";
                            tr += "<td>"+data[i].order_no+"</td>";
                            tr += "<td>"+data[i].user_id+"</td>";
                            tr += "<td>"+data[i].total_amount+"</td>";
                            tr += "<td>"+data[i].payment_id+"</td>";
                            tr += "<td>"+data[i].pay_status+"</td>";
                            tr += "<td>"+data[i].status+"</td>";
                            tr += "<td>"+data[i].updated_at+"</td>";
                            tr += "<td><a href='{{url('/weixin/admin/order/')}}/"+data[i].order_no+"' class='ui basic  button '>详情</a></td>";

                            a += tr;
                        }
                    }else{
                        a += "查不到数据.............";

                    }
                    
                    
                    $("#orderTable tbody").html(a);
                },
                error: function(xhr, type){
                    alert('Ajax error!')
                }
            });
        })
    </script>
@stop