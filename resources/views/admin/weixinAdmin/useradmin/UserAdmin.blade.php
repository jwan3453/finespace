@extends('admin.adminMaster')




@section('resources')

@stop

@section('content')
<div class="f-left right-side-panel">

    <div class="breadcrumb-nav">
        <div class="ui  large breadcrumb">
            <a class="section">主页</a> <i class="right angle icon divider"></i>
            <a class="section">分类管理</a>
        </div>
    </div>

    <div class="product-table">
        <table class="ui primary striped selectable table ">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>用户名</th>
                    <th>类型</th>
                    <th>创建时间</th>
                    <th>操作</th>
                </tr>
            </thead>

            <tbody>
                @foreach($list as $useradmin)

                    <tr>
                        <td>{{$useradmin->id}}</td>
                        <td>{{$useradmin->username}}</td>
                        <td>{{$useradmin->typename}}</td>
                        <td>{{$useradmin->creat_time}}</td>
                        <td>
                            <button class="ui basic  button " onclick="editUserAdmin({{$useradmin}})">编辑</button>
                            <button class="ui basic  button " onclick="delUserAdmin({{$useradmin->id}})">删除</button>
                        </td>
                    </tr>

                @endforeach
            </tbody>
            
    </table>
    <div class="table-content">

        <a class="f-right ui button primary" href="javascript:;" id="addUserName">添加管理员</a>
    </div>
    <div class="table-content"></div>
</div>

</div>

<div class="ui modal" id="edit-model"> <i class="close icon" id="close-i"></i>
<div class="header">编辑/添加 管理员</div>
<div  class="image content edit-model-form">
    <div class="ui form">
        <div class="field">
            <label>用户名</label>
            <input type="text" name="username" id="username"></div>
            <div class="field">
            <label>密码</label>
            <input type="text" name="password" id="password" placeholder="如果不想修改请留空"></div>
        <div class="field">
            <label>管理员等级</label>
            <select class="ui fluid dropdown" id="selectrole" name="roleId" ></select>
        </div>
       
    </div>

</div>
<div class="actions">
    <input type="hidden" name="useradminId" id="useradminId" value=""  />
    <input type="hidden" name="editOradd" id="editOradd" value="">
    <div class="ui black deny button" id="close">关闭</div>
    <div class="ui positive right  button" id="submit">提交</div>
</div>
</div>

<div class="ui modal" id="content-msg"> 
    <div class="header">提示</div>
    <div id="category-form" class="image content">
        <div class="content" id="content"></div>

    </div>
    <div class="actions">
        <div class="ui positive right  button" id="refresh">确定</div>
    </div>
</div>

<div class="ui modal" id="delCategory" >
    <div class="header">删除管理员 </div>
    <div class="content">
      <p>你确定删除该管理员吗？</p>
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
    function editUserAdmin(_this) {

        if (_this.status == 0) {
            $("#content").html("您不能对超级管理员进行操作！");
            $("#content-msg").modal('show');
        }else{
            $.ajax({
                type: 'POST',
                url: '/weixin/admin/useradmin/getRole',
                data: {},
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success: function(data){

                    $("#username").val(_this.username);
                    $("#useradminId").val(_this.id);
                    $("#editOradd").val("edit");
                    
                    for (var i = 0; i < data.length; i++) {
                       if (data[i].id == _this.status) {
                            $(".text").html(data[i].name);
                            $("#selectrole").append("<option value='"+data[i].id+"' selected='selected'>"+data[i].name+"</option>");
                       }else{
                            $("#selectrole").append("<option value='"+data[i].id+"' >"+data[i].name+"</option>");
                       }
                       
                    }

                    $("#edit-model").modal('setting', 'closable', false).modal('show');
                },
                error: function(xhr, type){
                    alert('Ajax error!')
                }
            });
        }

           
        } 


    $("#addUserName").click(function(){

        $.ajax({
                type: 'POST',
                url: '/weixin/admin/useradmin/getRole',
                data: {},
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success: function(data){

                    $("#username").val("");
                    $("#useradminId").val("");
                    $("#editOradd").val("add");
                    $("#selectrole").empty();
                    
                    for (var i = 0; i < data.length; i++) {
                       $("#selectrole").append("<option value='"+data[i].id+"' >"+data[i].name+"</option>");
                       
                    }

                    $("#edit-model").modal('setting', 'closable', false).modal('show');
                },
                error: function(xhr, type){
                    alert('Ajax error!')
                }
            });
    })

    $("#submit").click(function(){
        var editOradd = $("#editOradd").val();
        var username = $("#username").val();
        var selectrole = $("#selectrole").val();
        var useradminId = $("#useradminId").val();
        var password = $("#password").val();

        $.ajax({
            type: 'POST',
            url: '/weixin/admin/useradmin/editOraddUserAdmin',
            data: {editOradd : editOradd , username : username , selectrole : selectrole , useradminId : useradminId , password : password},
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            success: function(data){

                $("#content").html(data.statusMsg);
                $("#content-msg").modal('setting', 'closable', false).modal('show');
            },
            error: function(xhr, type){
                    alert('Ajax error!')
            }
        });
    })

    $("#close").click(function(){
            $("#username").val("");
            $("#password").val("");
            $("#selectrole").empty("");
            $("#useradminId").val("");
            $("#editOradd").val("");
        })

        $("#close-i").click(function(){
            $("#username").val("");
            $("#password").val("");
            $("#selectrole").empty("");
            $("#useradminId").val("");
            $("#editOradd").val("");
        })

    $("#refresh").click(function(){
            window.location.reload();
        })
</script>
@stop