@extends('admin.adminMaster')




@section('resources')
    <script src={{ asset('js/webuploader/webuploader.js') }}></script>
    <link rel="stylesheet" type="text/css"  href={{ asset('js/webuploader/webuploader.css') }}>
@stop

@section('content')


    <div class="f-left right-side-panel " >


        <div class="breadcrumb-nav">
            <div class="ui  large breadcrumb">
                <a class="section">主页</a>
                <i class="right angle icon divider"></i>
                <a class="section">添加商品</a>
            </div>
        </div>

        <form class="new-product-form" action="{{url('/weixin/admin/product/add')}}" method="post">

            <input type="hidden" id="selectCat" name="selectCat" />
            <input type="hidden" id="selectBrand" name="selectBrand"/>
            {!! csrf_field() !!}
            @include('admin.weixinAdmin.product.productDetail')
            <button type="submit" class=" ui button f-right red" id="submit"> 提交</button>
        </form>

    </div>



@stop

@section('script')
    <script type="text/javascript">


        $(document).ready(function(){

            $('.angle.down').click(function(){
                $(this).siblings('.sub-menu').slideToggle(300);
            })

            $(' .select-cat').dropdown({
                            onChange: function(value, text, $selectedItem) {
                                $('#selectCat').val(value);
                                //根据所选种类,加载产品属性
                                {{--$.ajax({--}}
                                    {{--url:'/weixin/admin/loadSpecs',--}}
                                    {{--type: 'POST',--}}
                                    {{--async: false,--}}
                                    {{--dataType: 'json',--}}
                                    {{--data:{categoryId:value},--}}
                                    {{--headers: {--}}
                                        {{--'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')--}}
                                    {{--},--}}
                                    {{--success: function (data) {--}}

                                        {{--var html ='';--}}
                                        {{--for(var i=0 ; i<data.extra.length;i++)--}}
                                        {{--{--}}
                                            {{--html = html+'<div class="common-input-box">'+--}}
                                                            {{--'<label>商品详情</label>'+--}}
                                                            {{--'<input class="transparent-input"  type="text"  name="'+data.extra[i].id+'" value="{{$product->sku}}"/>'+--}}
                                                        {{--'</div>';--}}
                                        {{--}--}}


                                    {{--},--}}
                                    {{--error: function (xhr, type) {--}}
                                        {{--//todo--}}
                                    {{--}--}}
                                {{--})--}}


                       }
            });

            $(' .select-brand').dropdown({
                        onChange: function(value, text, $selectedItem) {
                            $('#selectBrand').val(value);
                        }
            })


            $('#inventory,#price,#promotePrice').keyup(function(){

                $(this).val($(this).val().replace(/[^0-9.]/g,''));

            }).bind("paste",function(){  //CTR+V事件处理
                $(this).val($(this).val().replace(/[^0-9.]/g,''));
            }).css("ime-mode", "disabled"); //CSS设置输入法不可用



//        $.ajax({
//                url:'/weixin/loadCategory',
//                type: 'POST',
//                async: false,
//                dataType: 'json',
//                headers: {
//                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
//                },
//                success: function (data) {
//                  for(i=0; i< data.length;i++)
//                  {
//                      var catId = data[i]['id'];
//                      var catName = data[i]['name'];
//                      $('.select-cat').append('<option value="'+catId+'">'+catName+'</option>');
//
//                  }
//                    $(' .select-cat').dropdown({
//                            onChange: function(value, text, $selectedItem) {
//                                $('#selectCat').val(value);
//                        }
//                    })
//                },
//                error: function (xhr, type) {
//                    //todo
//                }
//            })
//
//
//            $.ajax({
//                url:'/weixin/loadBrand',
//                type: 'POST',
//                async: false,
//                dataType: 'json',
//                headers: {
//                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
//                },
//                success: function (data) {
//                    for(i=0; i< data.length;i++)
//                    {
//                        var brandId = data[i]['id'];
//                        var brandName = data[i]['name'];
//                        $('.select-brand').append('<option value="'+brandId+'">'+brandName+'</option>');
//
//                    }
//                    $(' .select-brand').dropdown({
//                        onChange: function(value, text, $selectedItem) {
//                            $('#selectBrand').val(value);
//                        }
//                    })
//                },
//                error: function (xhr, type) {
//                    //todo
//                }
//            })



//            $('#submit').click(function(){
//
//
//                $('#productDetialFields').slideToggle();
//
//                $('.product-image-upload').fadeIn();
//            })



        })
    </script>
@stop