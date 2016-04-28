@extends('weixinsite')

@section('content')


    <div class="category-header auto-margin">

            @if($type == 1)
                <div class="category-name  huge-font">精品推荐</div>
            @elseif($type == 2)
                <div class="category-name  huge-font">热销单品</div>
            @elseif($type == 3)
                <div class="category-name  huge-font">精品套餐</div>
            @endif
                <i class="angle double left icon big f-left go-back" onclick="history.back('-1')"></i>

    </div>


    <div id="my-divided" class="ui divided items">
        <!-- <a class="item active title-pro "> 布丁 </a> -->
        @foreach($product as $spc)

            <div id="my-item" class="item" >
                <div class="image">
                    <img src="{{ $spc->img }}"></div>
                <div class="content product-text">
                    <a class="header">{{ $spc->name }}</a>



                    <div class="product-tag">
                        @if(isset($spc->words))

                            @foreach($spc->words as $word)
                                <div>{{$word}}</div>

                            @endforeach
                        @endif
                    </div>

                    <div class="txt-length meta">
                        <span class="cinema">{{ $spc->desc }}</span>
                    </div>


                </div>
            </div>

        @endforeach

    </div>
@stop