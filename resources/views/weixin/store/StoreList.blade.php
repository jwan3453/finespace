@extends('weixinsite')


@section('resources')
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=9mVc34VYHPIqmoOCuy7KqWK8NMXtazoY"></script>
@stop

@section('content')
<div class="ui  container" style=" overflow:hidden;" id="homepage">


    @foreach($StoreList as $store)

    @if($store->is_display == 1)

    <div class="store-box auto-margin" >
        <div class="box-header">
            <a class="ui red ribbon label">门店信息</a> {{$store->name}}
            <i class="map icon big" id="Tmap"></i>
            <input id="store_id" type="hidden" value="{{$store->id}}" />
            <input id="longitude" type="hidden" value="{{$store->longitude}}">
            <input id="latitude" type="hidden" value="{{$store->latitude}}">
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
        
        <div class="store-map" id="allmap_{{$store->id}}" style="height:250px; width:100%;  clear:both;display:none;">
        </div>

    </div>

    @endif

    @endforeach

    <!-- <div id="allmap" class="allmap" ></div> -->
</div>
@stop

@section('script')
    <script type="text/javascript">

        $(".map.icon").click(function(){

            var store_id = $(this).siblings("#store_id").val();

            var longitude = $(this).siblings("#longitude").val();

            if (longitude == '' || longitude == null) {
                longitude = '118.102058';
            }

            var latitude = $(this).siblings("#latitude").val();

            if (latitude == '' || latitude == null) {
                latitude = '24.494934';
            }
    
            
            $(this).parent().siblings('.store-map').transition('scale');

            var map = new BMap.Map("allmap_"+store_id);
            var point = new BMap.Point(longitude, latitude);
            map.centerAndZoom(point, 20);

            // var geolocation = new BMap.Geolocation();
            // geolocation.getCurrentPosition(function(r){
            //     if(this.getStatus() == BMAP_STATUS_SUCCESS){
            //         var mk = new BMap.Marker(r.point);
            //         map.addOverlay(mk);
            //         map.panTo(r.point);
            //         // alert('您的位置：'+r.point.lng+','+r.point.lat);
            //         var my_map = '您的位置：'+r.point.lng+','+r.point.lat;
            //         console.log(my_map);


            //         var p1 = new BMap.Point(latitude,latitude);
            //         var p2 = new BMap.Point(r.point.lng,r.point.lat);

            //         var walking = new BMap.WalkingRoute(map, {renderOptions: {map: map, panel: "r-result", autoViewport: true}});
            //         walking.search(p2, p1);


            //     }
            //     else {
            //         alert('failed'+this.getStatus());
            //     }        
            // },{enableHighAccuracy: true})

            var marker = new BMap.Marker(point);  // 创建标注

            map.addOverlay(marker);               // 将标注添加到地图中
            marker.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的动画
            map.enableScrollWheelZoom(true); //设置鼠标滚轮
        })


        
    </script>
@stop