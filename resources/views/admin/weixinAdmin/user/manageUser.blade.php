@extends('admin.adminMaster')




@section('resources')

@stop

@section('content')


    <div class="f-left right-side-panel">


        <div class="breadcrumb-nav">
            <div class="ui  large breadcrumb">
                <a class="section">主页</a>
                <i class="right angle icon divider"></i>
                <a class="section">用户管理</a>
            </div>
        </div>



        <div class="user-table">

            <form method="post" action="/weixin/admin/user">
                <div class="ui icon input search-bar">
                    
                    <input type="text" placeholder="请输入手机号..." id="seachData" name="seachData" value="{{$seachData or ''}}" >
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <button class="ui circular search link icon button submit-btn" type="submit">
                        <i class="search link icon"></i>
                    </button>
                </div>
            </form>

            @if(count($users)>0)
                @include('admin.weixinAdmin.user.userTable')
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