@extends('weixinsite')

@section('resources')
    <script src={{ asset('js/jquery.form.js') }}></script>

    <link rel="stylesheet" type="text/css"  href={{ asset('css/mys.css') }}>

@stop

@section('content')




    <div class="ui  container member-box dark-bg" >


        <div class="member-info-box" id="menber-info-img">

            <img class="f-left ui medium circular image" src="{{$user->headImg}}" id="head_img">
            <div class="header huge-font">{{$user->mobile}}   </div>
            <div class="meta">普通会员 </div>
            <div class="description">余额: <span class="huge-font">￥{{$account->amount}} </span></div>

        </div>

        <ul class="vertical-list-menu member-menu-list" >
            <li class="menu-item"  >
                <a class="white-anchor" href="/weixin/order/all">
                <div class="f-left menu-icon" ><i class="user large  icon "></i></div>
                <div class="huge-font f-left menu-text">全部订单</div>
                <div class="f-right menu-icon"><i class="chevron  right icon large"></i></div>
                </a>
            </li>
            <li class=" menu-item"  >
                <a class="white-anchor" href="/weixin/order/all/0">
                    <div class="f-left menu-icon" ><i class="user large  icon "></i></div>
                    <div class="huge-font f-left menu-text">未付订单</div>
                    <div class="f-right menu-icon"><i class="chevron  right icon large"></i></div>
                </a>
            </li>
            <li class=" menu-item"  >
                <a class="white-anchor" href="/weixin/order/all/1">
                    <div class="f-left menu-icon" ><i class="user large  icon "></i></div>
                    <div class="huge-font f-left menu-text">已付订单</div>
                    <div class="f-right menu-icon"><i class="chevron  right icon large"></i></div>
                </a>
            </li>
            <li class=" menu-item"  >
                <div class="f-left menu-icon" ><i class="money large  icon "></i></div>
                <div class="huge-font f-left menu-text">账户余额</div>
                <div class="f-right menu-icon"><i class="chevron  right icon large"></i></div>
            </li>
            <li class="menu-item"  >
                <div class="f-left menu-icon" ><i class="location arrow large  icon "></i></div>
                <div class="huge-font f-left menu-text">地址管理</div>
                <div class="f-right menu-icon"><i class="chevron  right icon large"></i></div>
            </li>
        </ul>



    </div>


    <div class="ui modal"> <i class="close icon"></i>
        <div class="header">Profile Picture</div>
        <div class="image content">
            <div class="ui medium image">
                <img src="../img/image.png" id="files">
                <!-- <span class='delimg' id="delimg" rel=''>删除</span> -->
            </div>
            <div class="description">
                <div class="ui header">选择你要上传的图片</div>

                <div id="uploadfile">
                    <input id="fileupload" type="file" name="file">
                    <input id="UserId" name="UserId" value="{{$user->id}}" type="hidden" />
                </div>

                <div class="ui blue progress">
                  <div class="bar"><span class="percent">0%</span ></div>
                </div>
                <div id="showimg"></div>
            </div>
        </div>
        <div class="actions">
            <div class="ui black deny button">取消</div>
            <div class="ui positive right labeled icon button" id="TrueImg">
                确定<i class="checkmark icon"></i>
            </div>
        </div>
    </div>
@stop


@section('script')
    <script type="text/javascript">
        $(document).ready(function(){
            var bar = $('.bar');
            var percent = $('.percent');
            var showimg = $('#showimg');
            var progress = $(".progress");
            var files = $("#files");
            var btn = $(".btns span");
            $("#uploadfile").wrap("<form id='myupload' action='/weixin/member/addPic' method='post' enctype='multipart/form-data'></form>");
            $("#fileupload").change(function(){
                $("#myupload").ajaxSubmit({
                    dataType:  'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },

                    beforeSend: function() {
                        showimg.empty();
                        progress.show();
                        var percentVal = '0%';
                        bar.width(percentVal);
                        percent.html(percentVal);
                        btn.html("上传中...");
                    },
                    uploadProgress: function(event, position, total, percentComplete) {
                        var percentVal = 50 + '%';
                        bar.width(percentVal);
                        percent.html(percentVal);
                    },
                    success: function(data) {
                        bar.width('75%');
                        percent.html('75%');   

                        files.attr("src",data.extra.link);
                        $("#delimg").attr('rel',data.extra.key);

                        bar.width('100%');
                        percent.html('100%');  
                        console.log(data);
               
                    },
                    error:function(xhr){
                        btn.html("上传失败");
                        bar.width('0')
                        files.html(xhr.responseText);
                    }
                });
            });
        })

        $("#head_img").click(function(){
            var src = $("#head_img").attr("src");
            $("#files").attr("src",src);
            $('.ui.modal').modal('show');
        })

        $("#TrueImg").click(function(){
            var src = $("#files").attr("src");
            $("#head_img").attr("src",src);
        })

        // $("#delimg").click(function(){
        //     var key = $("#delimg").attr('rel');
        //     $.ajax({
        //         type: 'POST',
        //         url: '/weixin/member/DelUserHeadImg',
        //         data: {key : key},
        //         dataType: 'json',
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        //         },
        //         success: function(data){
        //             $("#content").html(data.statusMsg);
        //             $('#content-msg').modal('show');
        //             $("#category_id").val("");
        //         },
        //         error: function(xhr, type){
        //             alert('Ajax error!')
        //         }
        //     });
        //     alert(key);
        // })
    </script>
@stop