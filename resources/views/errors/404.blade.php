@extends('error')



@section('resources')


@stop

@section('content')



    <div class="error-box">


            <img class="auto-margin" src = '../img/doge.png'>
            <span class="giant-font">404 Page Not Found</span>
            <p class="giant-font">页面没找到，店小二打酱油去了</p>
            <a href="/"><div class="regular-btn red-btn auto-margin">带我回首页</div></a>

    </div>

@stop


@section('script')
    <script type="text/javascript">

        $(document).ready(function(){

        })
    </script>

@stop