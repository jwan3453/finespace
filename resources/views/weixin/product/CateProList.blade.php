@extends('weixinsite')

@section('content')


  	<div class="category-header auto-margin">
		<div style="width:120px;" class="auto-margin">
		@if($id == 1)
			<div class="icon-one f-left"></div>
			<div class="category-name f-left huge-font">布丁蛋糕</div>
		@elseif($id == 2)
			<div class="icon-two"></div>乳脂蛋糕
		@elseif($id == 3)
			<div class="icon-three"></div>穆斯蛋糕
		@elseif($id == 4)
			<div class="icon-four"></div>巧克力蛋糕
		@elseif($id == 5)
			<div class="icon-five"></div>
			芝士蛋糕
		@endif
		</div>
  	</div>


<div id="my-divided" class="ui divided items">
	<!-- <a class="item active title-pro "> 布丁 </a> -->

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