<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
	<style type="text/css">
	body, html,#allmap {width: 100%;height: 100%;overflow: hidden;margin:0;font-family:"微软雅黑";}
	</style>
	<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=9mVc34VYHPIqmoOCuy7KqWK8NMXtazoY"></script>
	<title>地图展示</title>
</head>
<body>
	<div id="allmap"></div>
</body>
</html>
<script type="text/javascript">
	// 百度地图API功能
	var map = new BMap.Map("allmap");
	var point = new BMap.Point(118.101698, 24.493627);
	map.centerAndZoom(point, 15);

	var geolocation = new BMap.Geolocation();
	geolocation.getCurrentPosition(function(r){
		if(this.getStatus() == BMAP_STATUS_SUCCESS){
			var mk = new BMap.Marker(r.point);
			map.addOverlay(mk);
			map.panTo(r.point);
			// alert('您的位置：'+r.point.lng+','+r.point.lat);
			var my_map = '您的位置：'+r.point.lng+','+r.point.lat;
			console.log(my_map);


			var p1 = new BMap.Point(118.101698,24.493627);
			var p2 = new BMap.Point(r.point.lng,r.point.lat);

			var walking = new BMap.WalkingRoute(map, {renderOptions: {map: map, panel: "r-result", autoViewport: true}});
			walking.search(p2, p1);


		}
		else {
			alert('failed'+this.getStatus());
		}        
	},{enableHighAccuracy: true})

	var marker = new BMap.Marker(point);  // 创建标注

	

	
	map.addOverlay(marker);               // 将标注添加到地图中
	marker.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的动画
	map.enableScrollWheelZoom(true); //设置鼠标滚轮
</script>