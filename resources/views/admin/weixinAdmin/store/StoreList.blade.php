@extends('admin.adminMaster')




@section('resources')
<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.3"></script>
@stop

@section('content')
<div class="f-left right-side-panel">

    <div class="breadcrumb-nav">
        <div class="ui  large breadcrumb">
            <a class="section">主页</a> <i class="right angle icon divider"></i>
            <a class="section">产品管理</a>
        </div>
    </div>

    <div class="product-table">
        <table class="ui primary striped selectable table ">
            <thead>
                <tr>
                    <th>类别ID</th>
                    <th>门店名称</th>
                    <th>地址</th>
                    <th>联系电话</th>
                    <th>是否配送</th>
                    <th>是否显示</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach($StoreList as $store)
                <tr>
                    <td>{{ $store->id }}</td>
                    <td>{{ $store->name }}</td>
                    <td>{{ $store->address }}</td>
                    <td>{{ $store->phone }}</td>
                    <td>

                        @if($store->is_distribution == 1)
                            是
                        @elseif($store->is_distribution == 0)
                            否
                        @endif
                    </td>
                    <td>
                        @if($store->is_display == 1)
                            是
                        @elseif($store->is_display == 0)
                            否
                        @endif
                    </td>

                    <td>

                        <button class="ui basic  button " onclick="editstore({{$store}})">编辑</button>
                        <button class="ui basic  button " onclick="delStore({{$store->id}})">删除</button>
                        <!-- <button class="ui basic red button ">下架</button>
                    -->
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="table-content">

        <a class="f-right ui button primary" href="javascript:;" id="addStore">添加分类</a>
    </div>
    <div class="table-content"></div>
</div>

</div>

<div class="ui modal" id="edit-model"> <i class="close icon" id="close-i"></i>
<div class="header">编辑/添加 门店</div>
<div id="category-form" class="image content">
    <div class="ui form">
        <div class="field">
            <label>名称</label>
            <input type="text" name="name" id="name"></div>
        <div class="field">
            <label>地址</label>
            <input type="text" name="address" id="address">
        </div>
        <div class="field">
            <label>电话</label>
            <input type="text" name="phone" id="phone">
        </div>

        <div class="inline fields">
            <label>是否配送</label>
            <div class="field">
                <div class="ui radio checkbox">
                    <input type="radio" name="is_distribution" value="1" id="is_distribution_1">        
                    <label>是</label>
                </div>
            </div>
            <div class="field">
                <div class="ui radio checkbox">
                    <input type="radio" name="is_distribution" value="0" id="is_distribution_0">        
                    <label>否</label>
                </div>
            </div>
            
        </div>

        <div class="inline fields">
            <label>是否显示</label>
            <div class="field">
                <div class="ui radio checkbox">
                    <input type="radio" name="is_display" value="1" id="is_display_1">        
                    <label>是</label>
                </div>
            </div>
            <div class="field">
                <div class="ui radio checkbox">
                    <input type="radio" name="is_display" value="0" id="is_display_0">        
                    <label>否</label>
                </div>
            </div>
            
        </div>


        <div class="fields">
            <div class="field">
                <label>经度</label>
                <input type="text" placeholder="经度" id="longitude" name="longitude"></div>
            <div class="field">
                <label>纬度</label>
                <input type="text" placeholder="纬度" id="latitude" name="latitude"></div>

            <div class="field">
                <label> 经、纬度获取</label>
                <button type="button" class="ui submit button" onclick="searchByStationName();">点击获取经纬度</button>
            </div>
        </div>

    </div>

</div>
<div class="actions">
    <input type="hidden" name="storeid" id="edit_storeid" value=""  />
    <input type="hidden" name="editOradd" id="editOradd" value="">
    <div class="ui black deny button" id="close">关闭</div>
    <div class="ui positive right  button" id="submit">提交</div>
</div>
</div>

<div class="ui modal" id="content-msg"> <i class="close icon" id="close-i"></i>
    <div class="header">提示</div>
    <div id="category-form" class="image content">
        <div class="content" id="content"></div>

    </div>
    <div class="actions">
        <div class="ui positive right  button" id="refresh">确定</div>
    </div>
</div>

<div class="ui modal" id="delStore" >
    <div class="header">删除门店 </div>
    <div class="content">
      <p>你确定删除该门店吗？</p>
      <input type="hidden" id="del_storeid" value="">
    </div>
    <div class="actions">
      <div class="ui negative button">取消 </div>
      <div class="ui positive right button" id="delStoreTrue">确定 </div>
    </div>
  </div>

<div id="container" 
            style="position: absolute;
                margin-top:30px; 
                width: 0px; 
                height: 0px; 
                top: 50; 
                border: 1px solid gray;
                overflow:hidden;">
        </div>

@stop

@section('script')
<script type="text/javascript">
        $(document).ready(function(){

            $('.angle.down').click(function(){
                $(this).siblings('.sub-menu').slideToggle(300);
            })
        })


        function editstore(_this) {
            
            $("#editOradd").val("edit");
            $("#edit_storeid").val(_this.id);
            $("#name").val(_this.name);
            $("#address").val(_this.address);
            $("#phone").val(_this.phone);
            $("#longitude").val(_this.longitude);
            $("#latitude").val(_this.latitude);
            $("#is_distribution_"+_this.is_distribution).attr("checked","checked");
            $("#is_display_"+_this.is_display).attr("checked","checked");
            $('#edit-model').modal('setting', 'closable', false).modal('show');
            $('.dropdown').dropdown({})
        }

        $("#close").click(function(){
            $("#editOradd").val("");
            $("#name").val("");
            $("#phone").val("");
            $("#address").val("");
            $("#longitude").val("");
            $("#latitude").val("");
            // $("#desc").val("");
            $("#edit_storeid").val("");
            $("#del_storeid").val("");
        })

        $("#close-i").click(function(){
            $("#editOradd").val("");
            $("#name").val("");
            $("#phone").val("");
            $("#address").val("");
            $("#longitude").val("");
            $("#latitude").val("");
            // $("#desc").val("");
            $("#edit_storeid").val("");
            $("#del_storeid").val("");
        })

        $("#submit").click(function(){
            var storeid = $("#edit_storeid").val();
            var name = $("#name").val();
            var address = $("#address").val();
            var phone = $("#phone").val();
            var longitude = $("#longitude").val();
            var latitude = $("#latitude").val();
            var is_distribution = $('input:radio[name="is_distribution"]:checked').val();
            var is_display = $('input:radio[name="is_display"]:checked').val();
            var editOradd = $("#editOradd").val();

            $.ajax({
                type: 'POST',
                url: '/weixin/admin/store/updateOraddStore',
                data: {storeid : storeid , name : name , address : address , phone : phone ,is_distribution : is_distribution, is_display : is_display, longitude : longitude, latitude : latitude , editOradd : editOradd},
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success: function(data){
                    $("#content").html(data.statusMsg);
                    $('#content-msg').modal('show');
                },
                error: function(xhr, type){
                    alert('Ajax error!')
                }
            });
        })

        $("#addStore").click(function(){
            
            $("#editOradd").val("add");
            $("#name").val("");
            // $("#parent_id").val("");
            $("#longitude").val("");
            $("#latitude").val("");
            $("#address").val("");
            $("#phone").val("");
            $('#edit-model').modal('show');
        })

        function delStore(id){
            $("#del_storeid").val(id);
            $("#delStore").modal('show');
        }

        $("#delStoreTrue").click(function(){
            var id = $("#del_storeid").val();
            $.ajax({
                type: 'POST',
                url: '/weixin/admin/category/delStore',
                data: {id : id},
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success: function(data){
                    $("#content").html(data.statusMsg);
                    $('#content-msg').modal('show');
                    $("#category_id").val("");
                },
                error: function(xhr, type){
                    alert('Ajax error!')
                }
            });
        })

        $("#refresh").click(function(){
            window.location.reload();
        })




        var map = new BMap.Map("container");
        map.centerAndZoom("厦门", 12);
        var localSearch = new BMap.LocalSearch(map);
        localSearch.enableAutoViewport(); //允许自动调节窗体大小
        function searchByStationName() {
            map.clearOverlays();//清空原来的标注
            var keyword = document.getElementById("address").value;
            localSearch.setSearchCompleteCallback(function (searchResult) {
                var poi = searchResult.getPoi(0);
                // document.getElementById("result_").value = poi.point.lng + "," + poi.point.lat;
                $("#longitude").val(poi.point.lng);
                $("#latitude").val(poi.point.lat);
                // map.centerAndZoom(poi.point, 13);
                // var marker = new BMap.Marker(new BMap.Point(poi.point.lng, poi.point.lat));  // 创建标注，为要查询的地方对应的经纬度
                // map.addOverlay(marker);
                // var content = document.getElementById("address").value + "<br/><br/>经度：" + poi.point.lng + "<br/>纬度：" + poi.point.lat;
                // var infoWindow = new BMap.InfoWindow("<p style='font-size:14px;'>" + content + "</p>");
                // marker.addEventListener("click", function () { this.openInfoWindow(infoWindow); });
                // marker.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的动画
            });
            localSearch.search(keyword);
        } 

    </script>
@stop