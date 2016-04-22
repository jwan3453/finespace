@extends('weixinsite')


@section('resources')
    <script src={{ asset('js/dateTime/mobiscroll.custom-2.17.0.min.js') }}></script>
    <link rel="stylesheet" type="text/css" href= {{ asset('js/dateTime/mobiscroll.custom-2.17.0.min.css') }}>

@stop
@section('content')

    <div class=" ui container cart-box ">

        <div >

        @foreach ($cartItemList as $cartItem)
            @if(isset($cartItem->product))
            <div class="cart-item">
                <input class="hidden-id" type="hidden" value="{{$cartItem->product_id}}">
                <img class="f-left" src ='{{$cartItem->product->thumb}}'>
                <div class="name ">{{$cartItem->product->name}}   </div>
                <div class="type">
                    ￥<span class="unit-price">{{$cartItem->product->price}}</span>

                </div>

                <i class=" remove big  icon red delete-item "></i>

                <div class="order-date-time ui left icon  fluid input ">
                    <i class=" calendar icon "></i> <input type="text" class="order-datetime"  id="orderDatetime_{{$cartItem->product->id}}" placeholder="预定时间" value="取货时间: {{$cartItem->order_dateTime}}"/>
                </div>

                <select class="ui fluid dropdown select-store ">

                    <option value="">选择取货门店</option>
                    @foreach($cartItemList['store']  as $store)
                        @if($store->id === $cartItem->selected_store)
                            <option value="{{$store->id}}" selected>{{$store->name}}</option>
                        @else
                            <option value="{{$store->id}}" >{{$store->name}}</option>
                        @endif
                    @endforeach

                </select>

                <div class="opt-qty-btns">
                    @if(auth::check() && $cartItem->product->category_id == 1)
                    <div class="opt-btn">
                        选项配置<i class="arrow circle down icon"></i>
                    </div>
                    @endif
                    <i class="icon-count f-right  plus large   icon red "></i>
                    <input class="f-right  big-font quantity" type="text" value="{{$cartItem->count}}"/>
                        <i class=" icon-count f-right minus large   icon teal "></i>
                </div>


                @if(Auth::check())
                <div class="options">

                    <div class="opt-product">

                        <input type="hidden" value="2"/>

                        <div class="opt-header">
                            餐具
                            <span class="f-right"><i class="pointing right icon"></i>长啥样？</span>
                        </div>

                        {{--<div class="small-font left">请选择数量(赠送一套)</div>--}}
                        {{--<div class="right small-font">总量:1套</div>--}}
                        <div class="sub-header small-font">
                            <span class="f-left">请选择数量(赠送一套)</span>
                            <span class="f-right">单价:￥<span class="option-product-unit-price">5</span></span>
                        </div>
                        <div class="sub-header small-font">
                            <i class=" f-left minus big circle icon teal "></i>
                            <input class="f-left  big-font " type="text" value="{{$cartItem['2']['count'] or 0}}"/>
                            <i class="f-left  plus big circle icon red "></i>
                            <span class="f-right">总价: ￥<span class="opt-product-total-price">{{  sprintf("%.2f", $cartItem['2']['totalAmount'])}}</span></span>
                        </div>
                    </div>

                    <div class="opt-product">

                        <input type="hidden" value="3"/>
                        <div class="opt-header">
                           蜡烛
                            <span class="f-right"><i class="pointing right icon"></i>长啥样？</span>
                        </div>
                        <div class="sub-header small-font">
                            <span class="f-left">请选择数量(赠送一套)</span>
                            <span class="f-right">单价:￥<span class="option-product-unit-price">5</span></span>
                        </div>
                        <div class="sub-header small-font">
                            <i class=" f-left minus big circle icon teal "></i>
                            <input class="f-left  big-font " type="text" value="{{$cartItem['3']['count'] or 0}}"/>
                            <i class="f-left  plus big circle icon red "></i>
                            <span class="f-right">总价:￥<span class="opt-product-total-price">{{  sprintf("%.2f", $cartItem['3']['totalAmount'])}}</span> </span>
                        </div>

                    </div>
                    {{--<div>--}}
                        {{--<div class=" opt-header">--}}
                            {{--备注--}}
                            {{--<span class="f-right"><i class="pointing right icon"></i>举个栗子？</span>--}}
                        {{--</div>--}}
                        {{--<div class=" sub-header small-font">可以写下祝福语啦</div>--}}

                        {{--<textarea class="greeting"  placeholder="happy birthday,生日快乐"></textarea>--}}
                    {{--</div>--}}
                </div>

                @endif


                <div class="product-price">
                    总价: <span class="huge-font">￥<span class="total-product-price">{{  sprintf("%.2f", $cartItem->totalAmount)}}</span> </span>

                </div>

            </div>
            @endif
        @endforeach


         @if(count($cartItemList) ==0)
             <div class = "no-cart-items">
                 <div class="empty-cart-icon auto-margin">

                 </div>

                <div class="empty-cart-text giant-font">
                   您的购物车空空如也
                </div>

                 <a href="/weixin"><div class="regular-btn auto-margin">去购物<i class="chevron circle  right icon big "></i></div></a>
             </div>
        @endif

        </div>
        @if(count($cartItemList) !=0)
        <div class="pos-spacing ">
        </div>
        <div class="check-out-box stick-btom">
            总计: <span class="giant-font ">￥<span class="total-cart-price">{{ $cartItemList['totalOrderAmount']}}</span></span>
            <a  class="confirm-btn f-right" href="/weixin/checkout/"><div>小二 · 买单</div></a>
        </div>
        @endif
        <div class="ui page dimmer dinnerBoxDimmer">
            <div class="  dimmer-box" >
                <h3>餐具</h3>

                <img src="/img/cake_ware.jpg">
            </div>
        </div>
    </div>

    <div class="ui page dimmer confirmDimmer">
        <div class="  dimmer-box" >
            <h3>是否从购物车删除</h3>

            <div class="ui buttons dimmer-btn big-font "  >
                <div class="regular-btn cancel "  >取消</div>
                <a class="or" data-text="-"></a>
                <div class="regular-btn red-btn confirm-delete"  >删除</div>
            </div>
        </div>
    </div>

@stop


@section('script')
    <script type="text/javascript">
        $(document).ready(function(){

            var itemCountMsgObj = $('.icon-message-count');
            var needDeleteItem;


            $('[id^=orderDatetime_]').mobiscroll().datetime({
                theme: 'Mobiscroll',
                display: 'bottom',
                lang: 'ZH',
                dateOrder:'ymmdd',
                cancelText:'取消',
                setText:'设置',
                yearText:'年份',
                monthText:'月份',
                dayText:'天',
                hourText:'小时',
                timeWheels:'HH',
                timeFormat:'HH:ii',
                dateFormat:'yy-mm-dd'
            });

            $(' .select-store').dropdown({
                onChange: function(value, text, $selectedItem) {
                    //$('#selectBrand').val(value);



                    //更改就餐或取货门店
                    $.ajax({
                        type: 'POST',
                        async : false,
                        url: '/weixin/updateSelectedStore',
                        dataType: 'json',
                        data:{productId:$(this).parent().siblings('.hidden-id').val(), newSelectedStore:value},
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        },
                        success: function(data)
                        {
                            var status  = data.statusCode;
                            if(status ==1 )
                            {
                                //时间跟新成功
                            }
                            else{
                                //时间跟新失败
                                _showToaster(data.statusMsg);
                            }

                        },
                        error: function(xhr, type){
                            alert('Ajax error!')
                        }

                    });


                }
            })

            $('.check-out-box').css('width',$('.cart-box').width());

            $('.delete-item').click(function(){
                needDeleteItem = $(this).parent();
                $('.confirmDimmer')
                        .dimmer('show',{closable:'false'})
                ;

            })

            $('.confirm-delete').click(function(){

                $('.confirmDimmer')
                        .dimmer('hide');
                ;


                //delete product from cookie
                //删除整个商品包括子商品
                deleteFromCart(needDeleteItem,0,1);

            })

            $('.cancel').click(function(){

                $('.confirmDimmer')
                        .dimmer('hide');
                ;

            })

            $('.opt-btn').click(function(){
                var currentOption = $(this);
                currentOption.parent().siblings('.options').transition('drop');


            })

            $('.opt-header').click(function(){
                $('.dinnerBoxDimmer')
                        .dimmer('show',{closable:'false'})
                ;

            })

            $('.plus').click(function(){

                var plusBtn =  $(this);


                //添加产品到购物车
                if(plusBtn.parent('.opt-qty-btns').length ===1 )
                {
                    addToCart(plusBtn,0);
                }
                else{

                    var optProductId = plusBtn.parents('.opt-product').find('input[type=hidden]').val();
                    addToCart(plusBtn,optProductId);
                }

            });


            $('.order-datetime').change(function(){
                $.ajax({
                    type: 'POST',
                    async : false,
                    url: '/weixin/updateOrderDateTime',
                    dataType: 'json',
                    data:{productId:$(this).parent().siblings('.hidden-id').val(), newOrderDateTime:$(this).val()},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success: function(data)
                    {
                        var status  = data.statusCode;
                        if(status ==1 )
                        {
                            //时间跟新成功
                        }
                        else{
                            //时间跟新失败
                            _showToaster(data.statusMsg);
                        }

                    },
                    error: function(xhr, type){
                        alert('Ajax error!')
                    }

                });
            })

            function addToCart(addItem,_subProductId)
            {

                var productId = 0;
                var parentProductId = 0;
                if(_subProductId > 0)
                {
                    parentProductId =addItem.parents('.options').siblings('.hidden-id').val();
                    productId = _subProductId;
                }
                else{
                    productId = addItem.parent().siblings('.hidden-id').val();
                }

                $.ajax({
                    type: 'POST',
                    async : false,
                    url: '/weixin/addToCart',
                    dataType: 'json',
                    data:{productId:productId, parentProductId:parentProductId},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success: function(data)
                    {
                        var status  = data.statusCode;
                        if(status ==1 )
                        {
                            var itemCount = 0;
                            if(!isNaN(parseInt(addItem.siblings('input').val())))
                            {

                                itemCount = parseInt(addItem.siblings('input').val());
                            }

                            addItem.siblings('input').val(itemCount+1);
                            itemCount = parseInt(itemCountMsgObj.text());
                            itemCount +=1;
                            $('.cart').transition('jiggle');
                            itemCountMsgObj.text(itemCount);

                            var cartItem = addItem.parents('.cart-item');
                            var  unitPrice = 0;

                            //添加主商品
                            if(_subProductId == 0 )
                            {

                                  unitPrice = parseFloat(cartItem.find('.unit-price').text());
                            }
                            //添加附属商品
                            else{

                                unitPrice = parseFloat(addItem.parents('.opt-product').find('.option-product-unit-price').text());
                                var optProductTotalPrice = addItem.parents('.opt-product').find('.opt-product-total-price');
                                optProductTotalPrice.text(parseFloat(optProductTotalPrice.text()) + unitPrice);


                            }
                            var totalProductPrice = cartItem.find('.total-product-price');
                            var totalCartPrice = $('.total-cart-price');
                            totalProductPrice.text( parseFloat(totalProductPrice.text()) + unitPrice);
                            totalCartPrice.text( parseFloat(totalCartPrice.text()) + unitPrice);


                        }
                        else{
                            _showToaster('加入购物车失败');
                        }

                    },
                    error: function(xhr, type){
                        alert('Ajax error!')
                    }

                });
            }



            $('.minus').click(function(){
                var minusBtn =  $(this);

                    //从购物车删除商品
                    if (minusBtn.parent('.opt-qty-btns').length === 1) {


                        if(parseInt(minusBtn.siblings('input').val()) === 1)
                        {

                            //删除整个商品
                            deleteFromCart(minusBtn.parents('.cart-item'),0,1);
                        }
                        else {
                            //删除一件商品
                            deleteFromCart(minusBtn, 0, 2);
                        }
                    }
                    else {

                        var optProductId = minusBtn.parents('.opt-product').find('input[type=hidden]').val();
                        //删除子商品
                        deleteFromCart(minusBtn, optProductId, 2);

                    }

            });




            function deleteFromCart(deleteItem,_subProductId,type){
                var productId = 0;
                var parentProductId = 0;
                if(_subProductId > 0)
                {
                    parentProductId =deleteItem.parents('.options').siblings('.hidden-id').val();
                    productId = _subProductId;
                }
                else{
                    //type 1 删除整个商品 包括子商品
                    //type 2 删除单个商品
                    if(type ==1)
                    {
                        productId = deleteItem.find('.hidden-id').val();
                    }
                    else if(type ==2) {
                        productId = deleteItem.parent().siblings('.hidden-id').val();
                    }


                }

                $.ajax({
                    type: 'POST',
                    async : false,
                    url: '/weixin/deleteFromCart',
                    dataType: 'json',
                    data:{productId:productId, parentProductId:parentProductId,type:type},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success: function(data)
                    {
                        var itemCount = 0;
                        var totalCartPrice = $('.total-cart-price');
                        if(type == 2) {
                            if(data.statusCode === 1)
                            {

                                if (!isNaN(parseInt(deleteItem.siblings('input').val()))) {

                                    itemCount = parseInt(deleteItem.siblings('input').val());
                                }

                                if (itemCount > 0) {
                                    deleteItem.siblings('input').val(itemCount - 1);
                                    itemCount = parseInt(itemCountMsgObj.text());
                                    itemCount -= 1;
                                    $('.cart').transition('jiggle');
                                    itemCountMsgObj.text(itemCount);

                                    var cartItem = deleteItem.parents('.cart-item');
                                    var  unitPrice = 0;

                                    //添加主商品
                                    if(_subProductId == 0 )
                                    {

                                        unitPrice = parseFloat(cartItem.find('.unit-price').text());
                                    }
                                    //添加附属商品
                                    else{

                                        unitPrice = parseFloat(deleteItem.parents('.opt-product').find('.option-product-unit-price').text());
                                        var optProductTotalPrice = deleteItem.parents('.opt-product').find('.opt-product-total-price');
                                        optProductTotalPrice.text(parseFloat(optProductTotalPrice.text()) - unitPrice);


                                    }
                                    var totalProductPrice = cartItem.find('.total-product-price');
                                    var totalCartPrice = $('.total-cart-price');
                                    totalProductPrice.text( parseFloat(totalProductPrice.text()) - unitPrice);
                                    totalCartPrice.text( parseFloat(totalCartPrice.text()) - unitPrice);
                                }
                            }
                        }
                        else if(type ==1)
                        {

                            if(data.statusCode === 1)
                            {
                                deleteItem
                                        .transition('fly up');
                                deleteItem.find('input[type=text]').each(function(){

                                    itemCount =itemCount + parseInt($(this).val());

                                })

                                itemCount = parseInt(itemCountMsgObj.text()) -  itemCount;
                                if(itemCount >=0)
                                {
                                    $('.cart').transition('jiggle');
                                    itemCountMsgObj.text(itemCount);
                                    if(_subProductId == 0 )
                                    {

                                        var totalProductPrice = deleteItem.find('.total-product-price');
                                        totalCartPrice.text( parseFloat(totalCartPrice.text()) - parseFloat(totalProductPrice.text()));
                                    }
                                }
                            }
                        }

                        if(itemCount == 0)
                        {
                            //如果购物车空了 跳转 刷新
                            location.href = "/weixin/cart";
                        }
                    },
                    error: function(xhr, type){
                        alert('Ajax error!')
                    }
                });
            }
        })
    </script>

@stop