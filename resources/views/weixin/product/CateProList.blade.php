@extends('weixinsite')

@section('content')

<div class="ui top attached tabular menu">
	 
  	<div class="active item">

  	@if($id == 1)
  		<div class="icon-one"></div>布丁
  	@elseif($id == 2)
  		<div class="icon-two"></div>乳脂
  	@elseif($id == 3)
  		<div class="icon-three"></div>穆斯
  	@elseif($id == 4)
  		<div class="icon-four"></div>巧克力
  	@elseif($id == 5)
  		<div class="icon-five"></div>芝士
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

			<div class="description">
				<p></p>
			</div>


			<div class="product-tag">
				@if(isset($spc->words))

					@foreach($spc->words as $word)
					<div>{{$word}}</div>
					
					@endforeach
				@endif
			</div>

			<div class="description">
				<p></p>
			</div>

			<div class="txt-length meta">
				<span class="cinema">{{ $spc->desc }}</span>
			</div>
			
			
		</div>
	</div>

	@endforeach
	
</div>
@stop