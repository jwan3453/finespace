@extends('admin.adminMaster')




@section('resources')

@stop

@section('content')


    <div class="f-left right-side-panel">


        <div class="breadcrumb-nav">
            <div class="ui  large breadcrumb">
                <a class="section">主页</a>
                <i class="right angle icon divider"></i>
                <a class="section">用户详情</a>
            </div>
        </div>



        <div class="">
            <div class="member-info-box" >

                <img class="f-left tiny ui image" src="/img/daft.png">
                <div class="header huge-font">{{$user->mobile}}   </div>
                <div class="meta">普通会员 </div>
                <div class="description">余额: <span class="huge-font">￥{{$account->amount}} </span></div>

            </div>

            @if(count($orders)>0)
                @include('admin.weixinAdmin.order.orderTable')
            @endif

        </div>

    </div>



@stop

@section('script')
    <script type="text/javascript">
        $(document).ready(function(){


        })
    </script>
@stop