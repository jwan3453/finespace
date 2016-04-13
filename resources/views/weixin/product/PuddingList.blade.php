@extends('weixinsite')

@section('content')

<div class="ui top attached tabular menu">
	 
  	<div class="active item"><div class="icon-one"></div>布丁</div>
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