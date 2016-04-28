@extends('weixinsite')

@section('content')


  	<div class="category-header auto-margin">
			@if(!count($product) == 0)
			<div class="category-name auto-margin  huge-font">{{$category->name}}</div>
				@else

				@endif
			<i class="angle double left icon big f-left go-back" onclick="history.back('-1')"></i>
  	</div>


<div id="my-divided" class="ui divided items">
	<!-- <a class="item active title-pro "> 布丁 </a> -->


	@if(count($product)==0)
		<div class="no-products huge-font">
			没有找到相关商品
		</div>
		<a href="/"><div class="regular-btn red-btn auto-margin">带我回首页</div></a>
	@endif


	@foreach($product as $spc)

	<div id="my-item" class="item">
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

@section('scripts')
	<script type="text/javascript">
		$(document).ready(function(){

		})
	</script>
@stop