@extends('weixinsite')

@section('content')




    <div class="ui  container member-box dark-bg" >


        <div class="member-info-box" >

            <img class="f-left tiny ui image" src="/img/icon_member.png">
            <div class="header huge-font">{{$user->mobile}}   </div>
            <div class="meta">普通会员 </div>
            <div class="description">余额: <span class="huge-font">￥{{$account->amount}} </span></div>

        </div>

        <ul class="vertical-list-menu member-menu-list" >
            <li class="menu-item"  >
                <a class="white-anchor" href="/weixin/order/all">
                <div class="f-left menu-icon" ><i class="user large  icon "></i></div>
                <div class="huge-font f-left menu-text">全部订单</div>
                <div class="f-right menu-icon"><i class="chevron  right icon large"></i></div>
                </a>
            </li>
            <li class=" menu-item"  >
                <a class="white-anchor" href="/weixin/order/all/0">
                    <div class="f-left menu-icon" ><i class="user large  icon "></i></div>
                    <div class="huge-font f-left menu-text">未付订单</div>
                    <div class="f-right menu-icon"><i class="chevron  right icon large"></i></div>
                </a>
            </li>
            <li class=" menu-item"  >
                <a class="white-anchor" href="/weixin/order/all/1">
                    <div class="f-left menu-icon" ><i class="user large  icon "></i></div>
                    <div class="huge-font f-left menu-text">已付订单</div>
                    <div class="f-right menu-icon"><i class="chevron  right icon large"></i></div>
                </a>
            </li>
            <li class=" menu-item"  >
                <div class="f-left menu-icon" ><i class="money large  icon "></i></div>
                <div class="huge-font f-left menu-text">账户余额</div>
                <div class="f-right menu-icon"><i class="chevron  right icon large"></i></div>
            </li>
            <li class="menu-item"  >
                <div class="f-left menu-icon" ><i class="location arrow large  icon "></i></div>
                <div class="huge-font f-left menu-text">地址管理</div>
                <div class="f-right menu-icon"><i class="chevron  right icon large"></i></div>
            </li>
        </ul>



    </div>
@stop


@section('script')
    <script type="text/javascript">
        $(document).ready(function(){


        })
    </script>
@stop