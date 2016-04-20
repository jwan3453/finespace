@extends('admin.adminMaster')




@section('resources')

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
                    <th>名称</th>
                    <th>上级分类</th>
                    <th>创建时间</th>
                    <th>更新时间</th>
                    <th>简介</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach($category as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->parent_name }}</td>
                    <td>{{ $category->created_at }}</td>
                    <td>{{ $category->updated_at }}</td>
                    <td>{{ $category->desc }}</td>

                    <td>

                        <button class="ui basic  button " onclick="editCategory({{$category}})">编辑</button>
                        <button class="ui basic  button " onclick="delCategory({{$category->id}})">删除</button>
                        <!-- <button class="ui basic red button ">下架</button>
                    -->
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="table-content">

        <a class="f-right ui button primary" href="javascript::void(0)" id="addCategory">添加分类</a>
    </div>
    <div class="table-content"></div>
</div>

</div>

<div class="ui modal" id="edit-model"> <i class="close icon" id="close-i"></i>
<div class="header">编辑/添加 分类</div>
<div  class="image content edit-model-form">
    <div class="ui form">
        <div class="field">
            <label>名称</label>
            <input type="text" name="name" id="name"></div>
        <div class="field">
            <label>上级分类</label>
            <select class="ui fluid dropdown" id="selectcategory" name="parent_id" ></select>
        </div>
        <div class="field">
            <label>简介</label>
            <textarea cols="" rows="3" name="desc" id="desc"></textarea>
        </div>
    </div>

</div>
<div class="actions">
    <input type="hidden" name="categoryid" id="categoryid" value=""  />
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

<div class="ui modal" id="delCategory" >
    <div class="header">删除分类 </div>
    <div class="content">
      <p>你确定删除该分类吗？</p>
      <input type="hidden" id="category_id" value="">
    </div>
    <div class="actions">
      <div class="ui negative button">取消 </div>
      <div class="ui positive right button" id="delCategoryTrue">确定 </div>
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


        function editCategory(_this) {
            $.ajax({
                type: 'POST',
                url: '/weixin/admin/category/getCategory',
                data: {categoryid : _this.id},
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success: function(data){
                    $("#selectcategory").append("<option value='0' selected='selected'>首级</option>");
                    $(".text").html("首级");
                    for (var i = 0; i < data.length; i++) {
                       if (data[i].id == _this.parent_id) {
                            $(".text").html("");
                            $("#selectcategory option:selected").remove();
                            $("#selectcategory").append("<option value='0'>首级</option>");
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
            $("#categoryid").val(_this.id);
            $("#name").val(_this.name);
            $("#parent_id").val(_this.parent_id);
            $("#desc").val(_this.desc);
            $('#edit-model').modal('setting', 'closable', false).modal('show');
            $('.dropdown').dropdown({})
        }

        $("#close").click(function(){
            $("#editOradd").val("");
            $("#name").val("");
            $("#parent_id").val("");
            $("#selectcategory").empty();
            $("#desc").val("");
            $("#categoryid").val("");
        })

        $("#close-i").click(function(){
            $("#editOradd").val("");
            $("#name").val("");
            $("#parent_id").val("");
            $("#selectcategory").empty();
            $("#desc").val("");
            $("#categoryid").val("");
        })

        $("#submit").click(function(){
            var name = $("#name").val();
            var parent_id = $("#selectcategory").val();
            var desc = $("#desc").val();
            var categoryid = $("#categoryid").val();
            var editOradd = $("#editOradd").val();

            $.ajax({
                type: 'POST',
                url: '/weixin/admin/category/updateOraddCategory',
                data: {categoryid : categoryid , name : name , parent_id : parent_id , desc : desc , editOradd : editOradd},
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

        $("#addCategory").click(function(){
            $.ajax({
                type: 'POST',
                url: '/weixin/admin/category/getCategory',
                data: {categoryid : 0},
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success: function(data){
                    $("#selectcategory").append("<option value='0' selected='selected'>首级</option>");
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
            // $("#parent_id").val("");
            $("#desc").val("");
            $("#categoryid").val("");
            $('#edit-model').modal('show');
        })

        function delCategory(id){
            $("#category_id").val(id);
            $("#delCategory").modal('show');
        }

        $("#delCategoryTrue").click(function(){
            var id = $("#category_id").val();
            $.ajax({
                type: 'POST',
                url: '/weixin/admin/category/delCategory',
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
    </script>
@stop