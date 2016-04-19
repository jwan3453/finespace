@extends('weixinsite')


@section('resources')

@stop

@section('content')
<div class="ui  container" style=" overflow:hidden;" id="homepage">


    @foreach($StoreList as $store)

    @if($store->is_display == 1)

    <div class="store-box auto-margin" >
        <div class="box-header">
            <a class="ui red ribbon label">门店信息</a> {{$store->name}}
        </div>

        <div class="box-content">
            <div class="content-image">
                <img src="../img/thumb_cake1.jpg"></div>

            <div class="content-words">
                <div class="words-address">
                    <i class="marker icon"></i>
                    <span class="address-content">
                        {{$store->address}}
                    </span>
                </div>

                <div class="words-phone">
                    <i class="call icon"></i>
                    <span>{{$store->phone}}</span>
                </div>

            </div>

        </div>
        
    </div>

    @endif

    @endforeach


</div>
@stop

@section('script')
<script type="text/javascript">
       
    </script>
@stop