@extends('admin.adminMaster')




@section('resources')

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

            {{--<div class="ui icon input search-bar">--}}
                {{--<input type="text" placeholder="请输入单号...">--}}
                {{--<i class="circular search link icon"></i>--}}
            {{--</div>--}}


                @include('admin.weixinAdmin.order.orderTable')


            {{--<div class="table-content">--}}

                {{--<a class="f-right ui button primary" href="{{url('/weixin/admin/product/add')}}">添加商品</a>--}}
            {{--</div>--}}
        </div>

    </div>



@stop

@section('script')
    <script type="text/javascript">
        $(document).ready(function(){


        })
    </script>
@stop