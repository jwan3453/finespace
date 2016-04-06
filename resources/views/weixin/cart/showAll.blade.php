@extends('weixinsite')

@section('content')

    <div class=" ui container cart-box ">

        <div >


             @foreach ($cartItemList as $cartItem)

            <div class="cart-item">
                <input class="hidden-id" type="hidden" value="{{$cartItem->product_id}}">
                <img class="f-left" src ='{{$cartItem->product->thumb}}'>
                <div class="name ">{{$cartItem->product->name}}   </div>
                <div class="type">
                    1.0磅 X 1

                </div>
                <div class="product-price">
                    总价: <span class="huge-font">{{$cartItem->product->price}} </span>

                </div>

                <i class=" remove big  icon red delete-item "></i>

                <div class="opt-qty-btns">
                    @if(auth::check())
                    <div class="opt-btn">
                        选项配置<i class="arrow circle down icon"></i>
                    </div>
                    @endif
                    <i class="icon-count f-right  plus large   icon red "></i>
                    <input class="f-right  big-font quantity" type="text" value="{{$cartItem->count}}"/>
                        <i class=" icon-count f-right minus large   icon teal "></i>
                </div>

                <div class="options">

                    <div class="opt-dinnerware">
                        <div class="opt-header">
                            餐具
                            <span class="f-right"><i class="pointing right icon"></i>长啥样？</span>
                        </div>

                        {{--<div class="small-font left">请选择数量(赠送一套)</div>--}}
                        {{--<div class="right small-font">总量:1套</div>--}}
                        <div class="sub-header small-font">
                            <span class="f-left">请选择数量(赠送一套)</span>
                            <span class="f-right">单价:￥5</span>
                        </div>
                        <div class="sub-header small-font">
                            <i class=" f-left minus big circle icon teal "></i>
                            <input class="f-left  big-font " type="text" value="{{$cartItem->dinnerWareCount}}"/>
                            <i class="f-left  plus big circle icon red "></i>
                            <span class="f-right">总价:￥5</span>
                        </div>
                    </div>

                    <div class="opt-candle">
                        <div class="opt-header">
                           蜡烛
                            <span class="f-right"><i class="pointing right icon"></i>长啥样？</span>
                        </div>
                        <div class="sub-header small-font">
                            <span class="f-left">请选择数量(赠送一套)</span>
                            <span class="f-right">单价:￥5</span>
                        </div>
                        <div class="sub-header small-font">
                            <i class=" f-left minus big circle icon teal "></i>
                            <input class="f-left  big-font " type="text" value="{{$cartItem->candleCount}}"/>
                            <i class="f-left  plus big circle icon red "></i>
                            <span class="f-right">总价:￥5</span>
                        </div>

                    </div>
                    <div>
                        <div class=" opt-header">
                            备注
                            <span class="f-right"><i class="pointing right icon"></i>举个栗子？</span>
                        </div>
                        <div class=" sub-header small-font">可以写下祝福语啦</div>

                        <textarea class="greeting"  placeholder="happy birthday,生日快乐"></textarea>
                    </div>
                </div>

            </div>
        @endforeach





        </div>

        <div class="pos-spacing ">
        </div>
        <div class="check-out-box stick-btom">
            总计:<span class="giant-font">￥2000</span>
            <a  class="confirm-btn f-right" href="/weixin/checkout/"><div>小二 · 买单</div></a>
        </div>

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

            var deleteItem;



            $('.check-out-box').css('width',$('.cart-box').width());

            $('.delete-item').click(function(){
                deleteItem = $(this).parent();
                $('.confirmDimmer')
                        .dimmer('show',{closable:'false'})
                ;

            })

            $('.confirm-delete').click(function(){

                $('.confirmDimmer')
                        .dimmer('hide');
                ;

                deleteItem
                        .transition('fly up')
                ;
                //delete product from cookie

                deleteFromCart(deleteItem);

            })

            $('.cancel').click(function(){

                $('.confirmDimmer')
                        .dimmer('hide');
                ;

            })

            $('.opt-btn').click(function(){
                var currentOption = $(this);
                currentOption.parent().siblings('.options').transition('fly left');
//                currentOption.parent().siblings('div').find('options').each(function(){
//                    alert('test');
//                    if($(this).css('display')!=='none')
//                    {
//                        alert("test");
//                        $(this).transition('fly left');
//                    }
//                })

            })

            $('.opt-header').click(function(){
                $('.dinnerBoxDimmer')
                        .dimmer('show',{closable:'false'})
                ;

            })

            $('.plus').click(function(){

               var plusBtn =  $(this);

                var itemCount =   parseInt(plusBtn.siblings('input').val());
                $(this).siblings('input').val(itemCount+1);
                 itemCount = parseInt($('.icon-message-count').text());
                itemCount +=1;
                if(itemCount === 0)
                {
                    $('.icon-message-count').removeClass('none-display').fadeIn();

                }
                else{
                    $('.cart').transition('jiggle');
                    $('.icon-message-count').text(itemCount);

                }

                if(plusBtn.parent('.opt-qty-btns').length ===1 )
                {
                    addToCart(plusBtn,0);
                }
                else{
                    if(plusBtn.parents('.opt-dinnerware').length ===1)
                    {
                        //添加餐具到购物车
                        addToCart(plusBtn,2);
                    }
                    else{
                        //添加蜡烛到购物车
                        addToCart(plusBtn,3);
                    }
                }



            });

            $('.minus').click(function(){


                var itemCount =   parseInt($(this).siblings('input').val());
                if(itemCount >= 1){
                    $(this).siblings('input').val(itemCount-1);
                }
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
                    productId = addItem.parent().siblings('.hidden-id').val();;
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

                        }
                        else{
                            alert('失败了');
                        }

                    },
                    error: function(xhr, type){
                        alert('Ajax error!')
                    }

                });
            }

            function deleteFromCart(deleteItem){
                $.ajax({
                    type: 'POST',
                    async : false,
                    url: '/weixin/deleteCookieProd',
                    dataType: 'json',
                    data:{productId: deleteItem.find('.hidden-id').val()},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success: function(data)
                    {
                        var itemCount  = data.statusCode;
                        if(itemCount !=1 )
                        {
                            $('.icon-message-count').removeClass('none-display').fadeIn();
                            $('.icon-message-count').text(itemCount);
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