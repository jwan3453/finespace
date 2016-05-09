@extends('admin.adminMaster')

@section('resources')

@stop

@section('content')
<div class="f-left right-side-panel">

  <div class="breadcrumb-nav">
    <div class="ui  large breadcrumb">
      <a class="section">主页</a> <i class="right angle icon divider"></i>
      <a class="section">权限管理</a>
    </div>
  </div>

  <div class="product-table">

    <div class="table-content">

      <a class="f-left ui button primary" href="javascript:;" id="addPermission">添加权限</a>
    </div>

    <div class="table-content">
      @foreach($Permission as $permission)
      <div class="ui checkbox">
        <input type="checkbox" name="permission" value="{{$permission->
        name}}">
        <label>{{$permission->display_name}}</label>
      </div>
      @endforeach
    </div>
  </div>

</div>

<div class="ui modal" id="add-model"> <i class="close icon" id="close-i"></i>
  <div class="header">添加权限</div>
  <div  class="image content edit-model-form">
    <div class="ui form">
      <div class="field">
        <label>名称</label>
        <input type="text" name="name" id="name"></div>
      <div class="field">
        <label>显示名称</label>
        <input type="text" name="display_name" id="display_name" placeholder=""></div>

    </div>

  </div>
  <div class="actions">
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
@stop

@section('script')
<script type="text/javascript">
  $("#addPermission").click(function(){
      $("#add-model").modal('setting', 'closable', false).modal('show');
  })

  $("#close").click(function(){
      $("#display_name").val("");
      $("#name").val("");
            
  })

  $("#close-i").click(function(){
      $("#display_name").val("");
      $("#name").val("");
           
  })

  $("#submit").click(function(){
    var name = $("#name").val();
    var display_name = $("#display_name").val();

    $.ajax({
        type: 'POST',
        url: '/weixin/admin/permission/addPermission',
        data: {display_name : display_name , name : name},
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        success: function(data){
            console.log(data);
            $("#content").html(data.statusMsg);
            $("#content-msg").modal('show');

            $("#display_name").val("");
            $("#name").val("");


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