@extends('admin.adminMaster')




@section('resources')

@stop

@section('content')


    <div class="f-left right-side-panel">

        <div class="statistic-box">
            <div class="title">
                今日订单总数
            </div>
            <div class="content">
                224
            </div>
        </div>
        <div class="statistic-box">
            <div class="title">
                今日新增用户
            </div>
            <div class="content">
                100
            </div>
        </div>
        <div class="statistic-box">
            <div class="title">
                产品总数
            </div>
            <div class="content">
                123
            </div>
        </div>
        <div class="statistic-box">
            <div class="title">
                总流水
            </div>
            <div class="content">
                200234+
            </div>
        </div>

    </div>



@stop

@section('script')
    <script type="text/javascript">
        $(document).ready(function(){

            $('.angle.down').click(function(){
                $(this).siblings('.sub-menu').slideToggle(300);
            })
        })
    </script>
@stop