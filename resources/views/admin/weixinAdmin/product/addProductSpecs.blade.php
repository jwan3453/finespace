@extends('admin.adminMaster')



@section('content')


    <div class="f-left right-side-panel" >

        <div class="breadcrumb-nav">
            <div class="ui  large breadcrumb">
                <a class="section">主页</a>
                <i class="right angle icon divider"></i>
                <a class="section">添加商品属性</a>
            </div>
        </div>

        <form class="new-product-form" action="{{url('/weixin/admin/product/addProductSpec')}}" method="post">

            <input type="hidden" id="productId" name="productId" value="{{$productId}}" />
            {!! csrf_field() !!}
            @include('admin.weixinAdmin.product.productSpecsDetail')
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
        })
    </script>
@stop