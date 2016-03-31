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