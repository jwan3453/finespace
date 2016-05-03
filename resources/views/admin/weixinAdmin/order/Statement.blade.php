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
                    <td colspan="3" id="order_no"></td>
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
                    <td class="form-width">库存</td>
                    <td class="form-width">状态</td>
                    <td class="form-width">门店地址</td>
                    <td class="form-width">操作</td>
                </tr>

                <tbody id="product">
                    
                </tbody>

                <tr>
                    <td></td>
                    <td></td>
                    <td>总计</td>
                    <td></td>
                    <td id="total_amount"></td>
                </tr>

            </table>

            <button class="primary ui button">&nbsp;&nbsp;&nbsp;结单&nbsp;&nbsp;&nbsp;</button>
            <button class="negative ui button">订单报错</button>

        </div>

    </div>

</div>


<div class="ui modal" id="content-msg"> <i class="close icon" id="close-i"></i>
    <div class="header">提示</div>
    <div id="category-form" class="image content">
        <div class="content" id="content"></div>

    </div>
    <div class="actions">
        <div class="ui positive right  button" id="refresh">确定</div>
    </div>
</div>
@stop

@section('script')
<script type="text/javascript">

    //---验证订单号是否正确
    $('#seachData').bind('input propertychange', function() {

        var seachData = $("#seachData").val();

        var reg =/^E[0-9]{12}[a-zA-Z0-9_]{11}$/;
        if (reg.test(seachData)) {
            $('#ToSeach').removeAttr("disabled");
        }else{
            $('#ToSeach').attr('disabled',"true");
        }

    });
       

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
                    $("#order_no").html(data.order_no);
                    $("#order_status").html(data.name);
                    $("#username").html(data.userData.name);
                    $("#phonenumber").html(data.userData.mobile);
                    $("#payment_status").html(data.payment_name);
                    $("#pay_status").html(data.pay_name);
                    $("#total_amount").html("￥ "+data.total_amount);

                    var a = "";

                    for (var i = 0; i < data.orderItems.length; i++) {
                        var product_detail = JSON.parse(data.orderItems[i].product_detail);

                        a += "<tr>";
                        a += "<td class='form-width'>"+product_detail.brief+"</td>";
                        a += "<td class='form-width'>"+product_detail.inventory+"</td>";
                        a += "<td class='form-width'>"+data.orderItems[i].statement_name+"</td>";
                        a += "<td class='form-width'>"+data.orderItems[i].Store_name+"</td>";
                        a += "<td class='form-width'></td>";
                        a += "</tr>";
                        // console.log(product_detail); 
                    }

                    $("#product").html(a);

                }
            },
            error: function(xhr, type){
                alert('Ajax error!')
            }
        });
    })
    </script>
@stop