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
            <form id="StructureForm">
                <div class="field">
                    <label>数据库表</label>
                    <select class="ui dropdown" name="table" onchange="getStructure(this)">
                        <option value=""></option>
                        @foreach($table as $table)
                        <option value="{{$table->
                            Tables_in_fine_space_wx}}" >{{$table->Tables_in_fine_space_wx}}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="inline fields">
                    <div class="eight wide field ">
                        <label class="field-num">填充量</label>
                        <input type="text" name="num"></div>
                   
                </div>

                <div id="Structure" >

                </div>

                <div class="field">
                    <a class="positive ui button"  onclick="Tosubmit()">提交</a>
                </div>

            </form>
        </div>
        <div class="table-content"></div>
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
    
    function getStructure(_this) {
        // console.log($(_this).val());

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

                for (var i = 0; i < data.length; i++) {
                    // console.log(data[i]);
                    a +=    "<div class='inline fields'>";
                    a +=        "<div class='eight wide field'>";
                    a +=            "<label>"+data[i]+"</label>";
                    a +=            "<select class='ui fluid search dropdown' name='"+data[i]+"_select' id='"+data[i]+"_select'>";
                    a +=                "<option value='1'>随机字符串</option>";
                    a +=                "<option value='2'>随机数字</option>";
                    a +=                "<option value='3'>固定值</option>";
                    a +=                "<option value='4'>时间区间</option>";
                    a +=            "</select>";
                    a +=        "</div>";
                    a +=        "<div class='three wide field'>";
                    a +=            "<input type='text' name='"+data[i]+"_min' id='"+data[i]+"_min'></div>";
                    a +=        "<div class='five wide field'>";
                    a +=            "<label>~</label>";
                    a +=            "<input type='text' name='"+data[i]+"_max' id='"+data[i]+"_max'></div>";
                    a +=    "</div>";

                }

                $("#Structure").html(a);
            },
            error: function(xhr, type){
                alert('Ajax error!')
            }
        });

    }

    function Tosubmit() {
        $.ajax({
            type: 'POST',
            url: '/weixin/admin/datafill/submitTableStructure',
            data: $('#StructureForm').serialize(),
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            success: function(data){
                // console.log(data);
                $("#content").val(data.statusMsg);
                $('#content-msg').modal('show');
            },
            error: function(xhr, type){
                alert('Ajax error!')
            }
        });
    }

</script>
@stop