@extends('admin.adminMaster')




@section('resources')

@stop

@section('content')
<div class="f-left right-side-panel">

    <div class="breadcrumb-nav">
        <div class="ui  large breadcrumb">
            <a class="section">主页</a> <i class="right angle icon divider"></i>
            <a class="section">数据填充</a>
        </div>
    </div>

    <div class="product-table">

        <div class="ui form">
            <div class="field">
                <label>数据库表</label>
                <select class="ui dropdown" onchange="getStructure(this)">
                    <option value=""></option>
                    @foreach($table as $table)
                        <option value="{{$table->Tables_in_fine_space_wx}}" >{{$table->Tables_in_fine_space_wx}}</option>
                    @endforeach
                </select>
            </div>

            <div id="Structure" class="field">
                
            </div>
        </div>
        <div class="table-content"></div>
    </div>

</div>



@stop

@section('script')
<script type="text/javascript">
    
    function getStructure(_this) {
        console.log($(_this).val());

        var table = $(_this).val();

        $.ajax({
            type: 'POST',
            url: '/weixin/admin/datafill/getTableStructure',
            data: {table : table},
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            success: function(data){
                var a = '';

                var b = "<select class='ui fluid search dropdown'>";
                b += "<option value='1'>随机字符串</option>";
                b += "<option value='2'>随机数字</option>";
                b += "<option value='3'>固定值</option>";
                b += "</select>";

                a += "<div class='field'><label>填充数据量</label><input type='text'></div>";
                a += "<div class='inline field'><label>id</label>"+b+"<label>长度</label><input type='text'></div>";

                $("#Structure").html(a);
            },
            error: function(xhr, type){
                alert('Ajax error!')
            }
        });

    }

</script>
@stop