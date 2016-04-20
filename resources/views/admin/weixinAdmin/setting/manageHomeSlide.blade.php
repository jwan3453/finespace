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
                <a class="section">{{$nav}}</a>
            </div>
        </div>




            <table class="ui primary striped selectable table slide-table">
                <thead>
                <tr>

                    <th>图片</th>
                    <th>活动连接</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($images as $image)
                    <tr id="{{$image->id}}_slide">
                        <td><img src ="{{$image->link}}" ></td>

                        <td><span class="slide-ad-link" >{{$image->ad_link}}</span></td>
                        <td>
                            <button class="ui basic  button edit " onclick="editSlide({{$image}})">编辑</button>
                            <button class="ui basic red button "  onclick="deleteSlide({{$image->id}})">删除</button>
                        </td>

                    </tr>

                @endforeach

           </table>

            {{--@include('admin.weixinAdmin.common.addImage')--}}

            <a href="/weixin/admin/editHomeSlide"><div class="regular-btn red-btn f-left">编辑轮播图</div></a>
    </div>


    <div class="ui modal" id="editSlide">
        <i class="close icon" id="close-i"></i>
        <div class="header">编辑</div>
        <form id="slide-form" class="image content edit-model-form">
            <div class="ui fluid  form " >
                <div class="ui fluid field">
                    <label>活动连接</label>
                    <input  type="text" name="adLink" id="adLink">
                    <input type="hidden" name="slideId" id="slideId">
                </div>
            </div>

        </form>

        <div class="actions">
            <input type="hidden" name="slideId" id="slideId" value=""  />
            <div class="ui black deny button" id="close">关闭</div>
            <div class="ui positive right  button" id="submit">提交</div>
        </div>
    </div>


    <div class="ui modal" id="delSlide" >
        <div class="header">删除幻灯片 </div>
        <div class="content">
            <p>你确定删除该幻灯片吗？</p>
            <input type="hidden" id="deleteSlideId" value="">
        </div>
        <div class="actions">
            <div class="ui negative button">取消 </div>
            <div class="ui positive right button" id="deleteSlideBtn">确定 </div>
        </div>
    </div>


@stop

@section('script')
    <script type="text/javascript">

        $(document).ready(function(){

            $('#submit').click(function(){
                $.ajax({
                    type: 'POST',
                    url: '/weixin/admin/setting/updateSlide',
                    data: {slideId : $('#slideId').val() , adLink : $('#adLink').val()},
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success: function(data){
                            $('#edit-model').modal('close');
                            $('#'+$('#slideId').val()+'_slide').find('.slide-ad-link').text( $('#adLink').val());
                            _showToaster(data.statusMsg);
                    },
                    error: function(xhr, type){
                        alert('Ajax error!')
                    }
                });

            })


            $('#deleteSlideBtn').click(function(){
                $.ajax({
                    type: 'POST',
                    url: '/weixin/admin/setting/deleteSlide',
                    data: {slideId : $('#deleteSlideId').val()},
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success: function(data){
                        $('#edit-model').modal('close');
                        if(data.statusCode ==1 )
                        {
                            $('#'+$('#deleteSlideId').val()+'_slide').remove();
                        }

                        _showToaster(data.statusMsg);
                    },
                    error: function(xhr, type){
                        alert('Ajax error!')
                    }
                });

            })
        })




        function editSlide(slideObj)
        {
            $('#editSlide').modal('show');
            $('#adLink').val(slideObj.ad_link);
            $('#slideId').val(slideObj.id);
        }
        function deleteSlide(slideId)
        {
            $('#delSlide').modal('show');
            $('#deleteSlideId').val(slideId);
        }


    </script>
@stop