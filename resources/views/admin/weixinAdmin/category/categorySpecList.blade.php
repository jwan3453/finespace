@extends('admin.adminMaster')




@section('resources')

@stop

@section('content')
<div class="f-left right-side-panel">

    <div class="breadcrumb-nav">
        <div class="ui  large breadcrumb">
            <a class="section">主页</a> <i class="right angle icon divider"></i>
            <a class="section">属性管理</a>
        </div>
    </div>

    <div class="product-table">
        <table class="ui primary striped selectable table ">
            <thead>
                <tr>
                    <th>类别ID</th>
                    <th>名称</th>
                    <th>所属分类</th>
                    <th>属性级别</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach($SpecList as $spec)
                <tr>
                    <td>{{ $spec->id }}</td>
                    <td>{{ $spec->name }}</td>
                    <td>{{ $spec->category_name }}</td>
                    <td>{{ $spec->spec_level }}</td>

                    <td>

                        <button class="ui basic  button " onclick="editSpec({{$spec}})">编辑</button>
                        <button class="ui basic  button " onclick="delSpec({{$spec->id}})">删除</button>
                        <!-- <button class="ui basic red button ">下架</button>
                    -->
                </td>
            </tr>
            @endforeach
        </tbody>
                <th></th>
                <th></th>
                <th colspan="3" style="padding:2px;">
                    <div>
                        {!! $SpecList->render() !!}
                    </div>
                </th>
                <th></th>
    </table>
    <div class="table-content">

        <a class="f-right ui button primary" href="javascript:;" id="addSpecInfo">添加属性</a>
    </div>
    <div class="table-content"></div>
</div>

</div>

<div class="ui modal" id="edit-model"> <i class="close icon" id="close-i"></i>
<div class="header">编辑/添加 属性</div>
<div  class="image content edit-model-form">
    <div class="ui form">
        <div class="field">
            <label>名称</label>
            <input type="text" name="name" id="name"></div>
        <div class="field">
            <label>所属分类</label>
            <select class="ui fluid dropdown" id="selectcategory" name="category_id" ></select>
        </div>
        <div class="field">
            <label>级别</label>
            <input type="text" name="spec_level" id="spec_level"></div>
    </div>

</div>
<div class="actions">
    <input type="hidden" name="editSpecId" id="editSpecId" value=""  />
    <input type="hidden" name="editOradd" id="editOradd" value="">
    <div class="ui black deny button" id="close">关闭</div>
    <div class="ui positive right  button" id="submit">提交</div>
</div>
</div>

<div class="ui modal" id="content-msg">
<i class="close icon" id="close-i"></i>
<div class="header">提示</div>
<div id="category-form" class="image content">
    <div class="content" id="content"></div>

</div>
<div class="actions">
    <div class="ui positive right  button" id="refresh">确定</div>
</div>
</div>

<div class="ui modal" id="delSpec" >
<div class="header">删除属性</div>
<div class="content">
    <p>你确定删除该属性吗？</p>
    <input type="hidden" id="deletespecId" value=""></div>
<div class="actions">
    <div class="ui negative button">取消</div>
    <div class="ui positive right button" id="delCategoryTrue">确定</div>
</div>
</div>
@stop

@section('script')
<script type="text/javascript">
        $(document).ready(function(){

            $('.angle.down').click(function(){
                $(this).siblings('.sub-menu').slideToggle(300);
            })
        })


        function editSpec(_this) {
            $.ajax({
                type: 'POST',
                url: '/weixin/admin/category/getAllCategoryNameInfo',
                data: {},
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success: function(data){
                    
                    for (var i = 0; i < data.length; i++) {
                       if (data[i].id == _this.category_id) {
                            $(".text").html(data[i].name);
                            $("#selectcategory").append("<option value='"+data[i].id+"' selected='selected'>"+data[i].name+"</option>");
                       }else{
                            $("#selectcategory").append("<option value='"+data[i].id+"' >"+data[i].name+"</option>");
                       }
                       
                    }
                },
                error: function(xhr, type){
                    alert('Ajax error!')
                }
            });
            $("#editOradd").val("edit");
            $("#editSpecId").val(_this.id);
            $("#name").val(_this.name);
            $("#spec_level").val(_this.spec_level);
            $('#edit-model').modal('setting', 'closable', false).modal('show');
            $('.dropdown').dropdown({})
        }

        $("#close").click(function(){
            $("#editOradd").val("");
            $("#name").val("");
            $("#editSpecId").val("");
            $("#selectcategory").empty();
            $("#spec_level").val("");
        })

        $("#close-i").click(function(){
            $("#editOradd").val("");
            $("#name").val("");
            $("#editSpecId").val("");
            $("#selectcategory").empty();
            $("#spec_level").val("");
        })

        $("#submit").click(function(){
            var name = $("#name").val();
            var categoryid = $("#selectcategory").val();
            var specId = $("#editSpecId").val();
            var spec_level = $("#spec_level").val();
            alert(specId);
            var editOradd = $("#editOradd").val();

            $.ajax({
                type: 'POST',
                url: '/weixin/admin/category/updateOraddSpecInfo',
                data: {categoryid : categoryid , name : name , specId : specId , spec_level : spec_level , editOradd : editOradd},
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

        $("#addSpecInfo").click(function(){
            $.ajax({
                type: 'POST',
                url: '/weixin/admin/category/getAllCategoryNameInfo',
                data: {},
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success: function(data){
                    for (var i = 0; i < data.length; i++) {
                       $("#selectcategory").append("<option value='"+data[i].id+"' >"+data[i].name+"</option>");
                       
                    }
                },
                error: function(xhr, type){
                    alert('Ajax error!')
                }
            });
            $("#editOradd").val("add");
            $("#name").val("");
            $("#editSpecId").val("");
            $("#spec_level").val("");
            $('#edit-model').modal('show');
        })

        function delSpec(id){
            $("#deletespecId").val(id);
            $("#delSpec").modal('show');
        }

        $("#delCategoryTrue").click(function(){
            var id = $("#specId").val();
            $.ajax({
                type: 'POST',
                url: '/weixin/admin/category/delSpecInfo',
                data: {id : id},
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success: function(data){
                    $("#content").html(data.statusMsg);
                    $('#content-msg').modal('show');
                    $("#specId").val("");
                },
                error: function(xhr, type){
                    alert('Ajax error!')
                }
            });
        })

        $("#refresh").click(function(){
            window.location.reload();
        })
    </script>
@stop