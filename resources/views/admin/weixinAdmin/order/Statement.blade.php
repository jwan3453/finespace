@extends('admin.adminMaster')

@section('resources')
<link rel="stylesheet" type="text/css" href= {{ asset('css/jquery-ui.min.css') }}>

<script src={{ asset('js/jquery-ui.min.js') }}></script>
@stop

        @section('content')
<div class="f-left right-side-panel">

    <div class="breadcrumb-nav">
        <div class="ui  large breadcrumb">
            <a class="section">主页</a> <i class="right angle icon divider"></i>
            <a class="section">店员结单</a>
        </div>
    </div>

    <div class="order-table">
        <div class="ui icon input search-bar">

            <input type="text" placeholder="请输入单号..."  id="seachData" name="seachData" >
            <button class="ui circular search link icon button submit-btn" type="button" id="ToSeach" disabled="disabled"> <i class="search link icon"></i>
            </button>
        </div>

        <div class="statement-table">

            <table class="ui primary striped selectable table ">

                <tr >
                    <td class="form-title" colspan="5">结单信息</td>
                </tr>

                <tr>
                    <td>单号</td>
                    <td colspan="2" id="order_no"></td>
                    <input type="hidden" id="order_id" />
                    <td>订单状态</td>
                    <td id="order_status"></td>
                </tr>

                <tr>
                    <td>用户名</td>
                    <td id="username"></td>
                    <td></td>
                    <td>用户电话</td>
                    <td id="phonenumber"></td>
                </tr>

                <tr>
                    <td>支付方式</td>
                    <td id="payment_status"></td>
                    <td></td>
                    <td>支付状态</td>
                    <td id="pay_status"></td>
                </tr>

                <tr>
                    <td colspan="5" class="form-title">订单产品</td>
                </tr>

                <tr>
                    <td class="form-width">名称</td>
                    <td class="form-width">时间(取餐/就餐)</td>
                    <td class="form-width">状态</td>
                    <td class="form-width">门店地址</td>
                    <td class="form-width">操作</td>
                </tr>

                <tbody id="product"></tbody>

                <tr>
                    <td></td>
                    <td></td>
                    <td>总计</td>
                    <td></td>
                    <td id="total_amount"></td>
                </tr>

            </table>

            <button class="primary ui button" onclick="check_Real_All()">&nbsp;&nbsp;&nbsp;结单&nbsp;&nbsp;&nbsp;</button>
            <!-- <button class="negative ui button">订单报错</button> -->

        </div>

    </div>

</div>

<div class="ui modal" id="content-msg">
    <i class="close icon" id="close-i"></i>
    <div class="header">提示</div>
    <div id="category-form" class="image content">
        <div class="content" id="content"></div>

    </div>
    <div class="actions">
        <div class="ui positive right  button" id="refresh">确定</div>
    </div>
</div>

<div class="ui modal" id="check-msg">
    <i class="close icon" id="close-i"></i>
    <div class="header">提示</div>
    <div id="category-form" class="image content">
        <div class="content" id="check_content"></div>

    </div>
    <div class="actions">
        <input type="hidden" id="orderItems_id" />
        <div class="ui positive right  button" id="check_Real">确定</div>
    </div>
</div>

<div class="ui modal" id="check-All-msg">
    <i class="close icon" id="close-i"></i>
    <div class="header">提示</div>
    <div id="category-form" class="image content">
        <div class="content" id="check_All_content">有一个以上的产品未确认！确定要全部结单吗？</div>

    </div>
    <div class="actions">
        <div class="ui positive right  button" id="check_All_Real">确定</div>
        <div class="ui negative right  button">取消</div>
    </div>
</div>
@stop

        @section('script')
<script type="text/javascript">

var confirmOrderItem;

//---验证订单号是否正确
$('#seachData').bind('input propertychange', function() {
    var seachData = $("#seachData").val();
        //验证订单信息
        var reg =/^E[0-9]{12}[a-zA-Z0-9_]{11}$/;
        if (reg.test(seachData)) {
            $('#ToSeach').removeAttr("disabled");
        }else{
            $('#ToSeach').attr('disabled',"true");
        }

    });
               

//通过单号获取详细信息并付到对应位置
$("#ToSeach").click(function(){
    var seachData = $("#seachData").val();
    $.ajax({
        type: 'POST',
        url: '/weixin/admin/order/seachStatementData',
        data: {seachData : seachData},
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        success: function(data){
            if (data.hasOwnProperty('statusCode')) {
                console.log(data);
                $("#content").html(data.statusMsg);
                $("#content-msg").modal("show");
            }else{
                $("#order_id").val(data.id);
                $("#order_no").html(data.order_no);
                $("#order_status").html(data.status_name);
                $("#username").html(data.userData.name);
                $("#phonenumber").html(data.userData.mobile);
                $("#payment_status").html(data.payment_name);
                $("#pay_status").html(data.pay_name);
                $("#total_amount").html("￥ "+data.total_amount);

                var a = "";

                for (var i = 0; i < data.orderItems.length; i++) {
                    var product_detail = JSON.parse(data.orderItems[i].product_detail);

                    a += "<tr class='order-item-line' statement="+data.orderItems[i].statement_status+">";
                    a += "<td class='form-width'>"+product_detail.brief+"</td>";
                    a += "<td class='form-width'>"+data.orderItems[i].order_dateTime+"("+data.orderItems[i].type_name+")</td>";
                    a += "<td class='form-width' >"+data.orderItems[i].statement_name+"</td>";
                    a += "<td class='form-width'>"+data.orderItems[i].Store_name+"</td>";

                    if (data.orderItems[i].statement_status == 1) {
                        a += '<td class="form-width"><i class="blue checkmark icon"></i></td>';
                    }else{
                        a += '<td class="form-width"><button class="ui teal basic button" onclick="checkReal('+data.orderItems[i].id+','+"'"+product_detail.brief+"'"+',this)">确认</button></td>';
                    }

                    a += "</tr>";
                }

                $("#product").html(a);

            }
        },
        error: function(xhr, type){
            alert('Ajax error!')
        }
    });
})


//点击单个产品结单弹出对话框
function checkReal(orderItems_id,product_name,_this) {
    var data = "确认结单 【 "+product_name+" 】 ?";
    $("#check_content").html(data);
    $("#orderItems_id").val(orderItems_id);
    $("#check-msg").modal("show");
    confirmOrderItem = _this;
    
}

//单个产品确认结单ajax操作并返回
$("#check_Real").click(function(){
    var orderItems_id = $("#orderItems_id").val();

    $.ajax({
        type: 'POST',
        url: '/weixin/admin/order/check_Real_One',
        data: {orderItems_id : orderItems_id},
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        success:function(data){
            $("#content").html(data.statusMsg);
            $("#content-msg").modal("show");

            if (data.statusCode == 1) {
                $(confirmOrderItem).parent().prev().prev().html("已消费");
                $(confirmOrderItem).parent().html('<i class="blue checkmark icon"></i>');
            }
        },
        error: function(xhr, type){
            alert('Ajax error!')
        }
    })
})

//结单全部弹出对话框
function check_Real_All() {
    var count1 = 0;
    var count2 = 0;
    //验证有几个产品未结算
    $("#product > tr").each(function(i,item){
        if ($(this).attr('statement') == 1) {
            count1++;
        }
        count2++;
    })

    if (count2 - count1 > 1) {
        $("#check-All-msg").modal('show');
    }
    else{
        $("#content").html("该订单已全部结单完毕！");
        $("#content-msg").modal("show");
    }
}

//结单所有产品ajax操作并返回
$("#check_All_Real").click(function(){
    var order_id = $("#order_id").val();

    $.ajax({
        type: 'POST',
        url: '/weixin/admin/order/check_All_Real',
        data: {order_id : order_id},
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        success:function(data){
            $("#content").html(data.statusMsg);
            $("#content-msg").modal("show");

            if (data.statusCode == 1) {
                $("#product > tr").each(function(i,item){
                    $(item).children().eq(2).html("已消费");
                    $(item).children().last().html('<i class="blue checkmark icon"></i>');
                    // console.log($(item).children().last());
                })
            }
        },
        error: function(xhr, type){
            alert('Ajax error!')
        }
    })
})

            
</script>
@stop