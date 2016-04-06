@extends('admin.adminMaster')




@section('resources')
    <script src={{ asset('js/webuploader/webuploader.js') }}></script>
    <link rel="stylesheet" type="text/css"  href={{ asset('js/webuploader/webuploader.css') }}>
@stop

@section('content')


    <div class="f-left right-side-panel">

        <div class="breadcrumb-nav">
            <div class="ui  large breadcrumb">
                <a class="section">主页</a>
                <i class="right angle icon divider"></i>
                <a class="section">添加商品</a>
            </div>
        </div>


        <div class="product-image-upload ">

            @if(count($images) > 0)
                <label>已上传图片</label>
                <div>
                    @foreach($images as $image)
                        <div  class="file-item thumbnail ui  image uploaded ">
                            <div class="image-mask " id="cover_{{$image->id}}">
                                <div class="set-cover  regular-btn red-btn">设为封面</div>
                            </div>
                            <div class="ui blue ribbon label cover " id="cover_{{$image->id}}">封面</div>
                            <i class="remove icon large orange "> </i>
                            <img style="width:200px;height:200px" src={{$image->link}} >
                            <div class="info"> {{$image->key}}</div>
                            <input type="hidden"  class="image-key" value="{{$image->key}}">
                            <input type="hidden" class="image-id" value="{{$image->id}}">
                        </div>
                    @endforeach
                </div>

            @endif


            <label>新增产品图片</label>
            <div>
                <!--用来存放item-->
                <div id="fileList" class="uploader-list" >

                </div>
                <div style="clear:both;display:block; ">
                    <div id="filePicker" class="f-left "  style="margin-right:20px;">选择图片</div>
                    <div id="uploadImages" class=" f-left regular-btn red-btn">开始上传</div>
                </div>
            </div>

        </div>


    </div>
    <div class="ui page dimmer confirmDimmer">
        <div class="  dimmer-box" >
            <h3>是否删除上传的照片</h3>

            <div class="ui buttons dimmer-btn big-font "  >
                <div class="regular-btn cancel-delete "  >取消</div>
                <a class="or" data-text="-"></a>
                <div class="regular-btn red-btn confirm-delete"  >删除</div>
            </div>
        </div>
    </div>

@stop

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {

            var imageObj = '';
            var imageKey = '';
            var uploader = WebUploader.create({

                // swf文件路径
                swf: '/js/webuploader/Uploader.swf',

                // 文件接收服务端。
                server: '/weixin/uploadImage',

                // 选择文件的按钮。可选。
                // 内部根据当前运行是创建，可能是input元素，也可能是flash.
                pick: '#filePicker',

                // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
                resize: false,
                // 只允许选择图片文件。

                accept: {
                    title: 'Images',
                    extensions: 'gif,jpg,jpeg,bmp,png',
                    mimeTypes: 'image/*'
                },
                'formData': {

                    '_token': '{{ csrf_token() }}',
                    'productId':'{{$productId}}'
                },
            });
            // 当有文件添加进来的时候
            uploader.on('fileQueued', function (file) {

                var $li = $(
                                '<div id="' + file.id + '" class="file-item thumbnail ui  image">' +

                                '<div class=" ui  blue   ribbon label upload-success ">上传成功 </div>' +
                                '<div class="ui  red   ribbon label upload-failed">上传失败 </div>' +
                                '<i class="remove icon large orange "> </i>' +
                                '<img>' +
                                '<div class="info">' + file.name + '</div>' +
                                ' <div class="loader-box none-display ">' +
                                '<div class="ui active centered large inline loader   "></div>' +
                                '</div>' +
                                '</div>'
                        ),
                        $img = $li.find('img');


                // $list为容器jQuery实例
                $('#fileList').append($li);

                // 创建缩略图
                // 如果为非图片文件，可以不用调用此方法。
                // thumbnailWidth x thumbnailHeight 为 100 x 100
                uploader.makeThumb(file, function (error, src) {
                    if (error) {
                        $img.replaceWith('<span>不能预览</span>');
                        return;
                    }

                    $img.attr('src', src);
                }, 200, 200);
            });

            // 文件上传过程中创建进度条实时显示。
            uploader.on('uploadProgress', function (file, percentage) {

                var $li = $('#' + file.id),
                        $loader = $li.find('.loader-box');

                // 避免重复创建
                $loader.removeClass('none-display');

            });

            // 文件上传成功，给item添加成功class, 用样式标记上传成功。
            uploader.on('uploadSuccess', function (file, response) {

                if (response.statusCode == 1) {
                    var html ='<div class="image-mask " >'+
                            '<div class="set-cover  regular-btn red-btn">设为封面</div>'+
                            '</div>'+
                            '<div class="ui blue ribbon label cover " >产品封面</div>'+
                            '<input type="hidden" class="image-key" value="' + response.extra['key'] + '">'+
                            '<input type="hidden" class="image-id" value="' + response.extra['id'] + '">';

                    $('#' + file.id).find('.upload-success').show();
                    $('#' + file.id).append(html);

                }
                else {
                    $('#' + file.id).find('.upload-failed').show();
                }

            });

            // 文件上传失败，显示上传出错。
            uploader.on('uploadError', function (file) {
                $('#' + file.id).find('.upload-failed').show();
            });


            // 完成上传完了，成功或者失败，先删除进度条。
            uploader.on('uploadComplete', function (file) {

                $('#' + file.id).find('.loader-box').remove();
                $('#' + file.id).find('.remove').removeClass('none-display');
                $('#' + file.id).addClass('upload-complete');
            });


            //批量上传图片
            $('#uploadImages').click(function () {


                $('.file-item.thumbnail').each(function () {

                    if (!$(this).hasClass('upload-complete')) {
                        uploader.upload($(this).attr('id'));
                    }
                })

            })

            $(document).on('click', '.remove', function () {

                var key = $(this).siblings('.image-key').val();
                imageObj = $(this).parent();
                if ( key !== undefined &&  key !== '' ) {


                    imageKey = key;
                    $('.confirmDimmer')
                            .dimmer('show');
                    ;
                }
                else
                {
                    uploader.removeFile( imageObj.attr('id') );
                    imageObj.fadeOut(1000);
                }

            });

            $('.confirm-delete').click(function () {
                $.ajax({

                    type: 'POST',
                    async: false,
                    url: '/wexin/deleteImage',
                    data: {imageKey: imageKey},
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success: function (data) {
                        $('.confirmDimmer')
                                .dimmer('hide',{
                                    duration    : {
                                        show : 100,
                                        hide : 100
                                    }
                                });

                        //删除成功
                        if(data.statusCode===1)
                        {

                            _showToaster(data.statusMsg);
                            //区别删除的图片是否为后来添加的
                            if(!imageObj.hasClass('uploaded'))
                            {
                                uploader.removeFile( imageObj.attr('id') );
                            }
                            imageObj.fadeOut(1000);

                        }
                        else{

                            _showToaster(data.statusMsg);
                        }
                    },
                    error: function (xhr, type) {
                        alert('Ajax error!');
                    }
                });

            })
            $('.cancel-delete').click(function () {

                $('.confirmDimmer')
                        .dimmer('hide');
                ;
            });


//            $('.file-item').hover(
//                    function(){
//                        $(this).find('.image-mask').transition('scale')
//                    },
//                    function(){
//                        $(this).find('.image-mask').transition('scale')
//
//                    }
//            )



            $(document).on('mouseenter ', '.file-item', function(){

                    $(this).find('.image-mask').toggle(300);




            })
            $(document).on('mouseleave', '.file-item', function(){


                $(this).find('.image-mask').removeClass('visible,transition').hide();
            })

            //设置图像为产品封面
            $(document).on('click', '.set-cover', function(){
                var coverLabel = $(this).parent().siblings('.cover');
                $.ajax({
                    type: 'POST',
                    async: false,
                    url: '/weixin/setImageCover',
                    data: {type: 1,associateId:'{{$productId}}',imageId:$(this).parent().siblings('.image-id').val()},
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success: function (data) {

                        if(data.statusCode===1)

                        {

                            $('.cover').hide();
                            coverLabel.show();
                        }
                        else{

                            _showToaster(data.statusMsg);
                        }
                    },
                    error: function (xhr, type) {
                        alert('Ajax error!');
                    }
                });
            })

            var coverId = 'cover_' + '{{$productThumbID}}';

            $('.cover').each(function(){

                if($(this).attr('id') ===coverId)
                {
                    $(this).show();
                }
            })

        })
    </script>
@stop