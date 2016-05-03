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
        
        <form method="post" action="Addpermission">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        <input type="submit" value="确定" />
        </form>

        <div class="ui huge labels">
          <a class="ui teal label">Teal</a>
          <a class="ui teal label">Teal</a>
          <a class="ui teal label">Teal</a>
          <a class="ui teal label">Teal</a>
          <a class="ui teal label">Teal</a>
          <a class="ui teal label">Teal</a>

        </div>


        <div class="ui huge labels">
          <a class="ui pink label">pink </a>
          <a class="ui pink label">pink </a>
          <a class="ui pink label">pink </a>
          <a class="ui pink label">pink </a>
          <a class="ui pink label">pink </a>
          <a class="ui pink label">pink </a>
          
        </div>
    </div>

    

</div>

@stop

@section('script')
<script type="text/javascript">

</script>
@stop