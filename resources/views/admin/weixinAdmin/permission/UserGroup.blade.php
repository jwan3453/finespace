@extends('admin.adminMaster')


@section('resources')

@stop

@section('content')
<div class="f-left right-side-panel">

    <div class="breadcrumb-nav">
        <div class="ui  large breadcrumb">
            <a class="section">主页</a> <i class="right angle icon divider"></i>
            <a class="section">用户组管理</a>
        </div>
    </div>

    <div class="product-table">
        <table class="ui primary striped selectable table ">
            <thead>
                <tr>
                    <th>类别ID</th>
                    <th>名称</th>
                    <th>显示名称</th>
                    <th>描述</th>
                    <th>添加时间</th>
                    <th>更新时间</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach($RoleLst as $Role)
                <tr>
                    <td>{{ $Role->id }}</td>
                    <td>{{ $Role->name }}</td>
                    <td>{{ $Role->display_name }}</td>
                    <td>{{ $Role->description }}</td>
                    <td>{{ $Role->created_at }}</td>
                    <td>{{ $Role->updated_at }}</td>
                    <td>

                        <button class="ui basic  button " onclick="editRole({{$Role}})">编辑</button>
                        <button class="ui basic  button " onclick="delRole({{$Role->id}})">删除</button>
                        <a class="ui basic red button " href="/weixin/admin/permission/UserGroupPermission/{{ $Role->id }}">编辑权限</a>
                   
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="table-content">

        <a class="f-right ui button primary" href="javascript::void(0)" id="addRole">添加用户组</a>
    </div>
    <div class="table-content"></div>
</div>

</div>

<div class="ui modal" id="edit-model"> <i class="close icon" id="close-i"></i>
<div class="header">编辑/添加 用户组</div>
<div  class="image content edit-model-form">
    <div class="ui form">
        <div class="field">
            <label>名称</label>
            <input type="text" name="name" id="name"></div>
        <div class="field">
            <label>显示名称</label>
           <input type="text" name="display_name" id="display_name"></div>
        <div class="field">
            <label>描述</label>
            <textarea cols="" rows="3" name="description" id="description"></textarea>
        </div>
    </div>

</div>
<div class="actions">
    <input type="hidden" name="roleid" id="roleid" value=""  />
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
    <div class="header">删除用户组 </div>
    <div class="content">
      <p>你确定删除该用户组吗？</p>
      <input type="hidden" id="role_id" value="">
    </div>
    <div class="actions">
      <div class="ui negative button">取消 </div>
      <div class="ui positive right button" id="delRoleTrue">确定 </div>
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


        function editRole(_this) {
           
            $("#editOradd").val("edit");
            $("#roleid").val(_this.id);
            $("#name").val(_this.name);
            $("#display_name").val(_this.display_name);
            $("#description").val(_this.description);
            $('#edit-model').modal('setting', 'closable', false).modal('show');
            $('.dropdown').dropdown({})
        }

        $("#close").click(function(){
            $("#editOradd").val("");
            $("#name").val("");
            $("#display_name").val("");
       
            $("#description").val("");
            $("#roleid").val("");
        })

        $("#close-i").click(function(){
            $("#editOradd").val("");
            $("#name").val("");
            $("#display_name").val("");
            $("#description").val("");
            $("#roleid").val("");
        })

        $("#submit").click(function(){
            var name = $("#name").val();
            var display_name = $("#display_name").val();
            var description = $("#description").val();
            var roleid = $("#roleid").val();
            var editOradd = $("#editOradd").val();

            $.ajax({
                type: 'POST',
                url: '/weixin/admin/permissions/updateOraddRole',
                data: {roleid : roleid , name : name , display_name : display_name , description : description , editOradd : editOradd},
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

        $("#addRole").click(function(){
            
            $("#editOradd").val("add");
            $("#name").val("");
            $("#description").val("");
            $("#roleid").val("");
            $('#edit-model').modal('show');
        })

        function delRole(id){
            $("#role_id").val(id);
            $("#delCategory").modal('show');
        }

        $("#delRoleTrue").click(function(){
            var id = $("#role_id").val();
            $.ajax({
                type: 'POST',
                url: '/weixin/admin/permissions/delRole',
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