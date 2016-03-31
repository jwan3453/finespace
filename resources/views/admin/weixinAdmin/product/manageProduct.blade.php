@extends('admin.adminMaster')




@section('resources')

@stop

@section('content')


    <div class="f-left right-side-panel">


        <div class="breadcrumb-nav">
            <div class="ui  large breadcrumb">
                <a class="section">主页</a>
                <i class="right angle icon divider"></i>
                <a class="section">产品管理</a>
            </div>
        </div>



        <div class="product-table">
            <table class="ui primary striped selectable table ">
            <thead>
            <tr>
                <th>商品ID</th>
                <th>名称</th>
                <th>库存</th>
                <th>价格</th>
                <th>状态</th>
                <th>简介</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{$product->id}}</td>
                    <td>{{$product->name}}</td>
                    <td>{{$product->inventory}}</td>
                    <td>{{$product->price}}</td>
                    <td>{{$product->status}}</td>
                    <td>{{$product->brief}}</td>
                    <td>

                        <a href="{{url('/weixin/admin/product/edit').'/'.$product->id}}" class="ui basic  button ">编辑</a>
                        <button class="ui basic red button ">下架</button>
                    </td>
                </tr>

                @endforeach
            </tbody>
                <th >
                </th>
                <th >
                </th>
                <th></th>
                <th></th>
                <th></th>
                <th colspan="3" style="padding:2px;">
                    <div>
                        {!! $products->render() !!}
                    </div>
                </th>
                <th></th>
        </table>
            <div class="table-content">

                <a class="f-right ui button primary" href="{{url('/weixin/admin/product/add')}}">添加商品</a>
            </div>
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
    </script>
@stop