@extends('weixinsite')

@section('content')


    <div class="category-header auto-margin">

        <i class="angle double left icon big f-left go-back" onclick="history.back('-1')"></i>
    </div>


    <div >

            <div class="no-products huge-font">
                {{$message}}
            </div>
            <a href="/"><div class="regular-btn red-btn auto-margin">带我回首页</div></a>
    </div>
@stop

@section('scripts')

@stop