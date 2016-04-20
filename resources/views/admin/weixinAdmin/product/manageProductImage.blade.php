@extends('admin.adminMaster')




@section('resources')
    <script src={{ asset('js/webuploader/webuploader.js') }}></script>
    <link rel="stylesheet" type="text/css"  href={{ asset('js/webuploader/webuploader.css') }}>
@stop

@section('content')

    <div class="f-left right-side-panel">


        <div class="breadcrumb-nav">
            <div class="ui  large breadcrumb">
                <a class="section">主页</a>
                <i class="right angle icon divider"></i>
                <a class="section">{{$nav}}</a>
            </div>
        </div>
    @include('admin.weixinAdmin.common.addImage')

    </div>


@stop

@section('script')
    <script type="text/javascript">
        $(document).ready(function(){


        })
    </script>
@stop