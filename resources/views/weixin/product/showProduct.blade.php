@extends('weixinsite')



@section('resources')

    <script src={{ asset('js/swiper/jquery.excoloSlider.min.js') }}></script>
    <link rel="stylesheet" type="text/css" href= {{ asset('js/swiper/jquery.excoloSlider.css') }}>
@stop

@section('content')

    <div class=" ui container prod-detail-box"  >

        <div class="prod-image-slide" >
            <div id="slider">
                @foreach($product->img as $img)
                    <img src="{{$img}}">
                @endforeach
            </div>

        </div>

        <div class="prod-spec">
            <div class="huge-font name">{{$product->name}}</div>
            <div class=" extra ">

                <div class="product-tag">
                    <div >
                        白兰地
                    </div>
                    <div >
                        巧克力
                    </div>
                    <div >
                        樱桃
                    </div>
                    <div >
                        白兰地
                    </div>
                </div>
            </div>



            <div class="specs specs-level2 ">
                @foreach( $product->spec as $spec)
                    @if($spec['level'] == 2)
                        <div class="ui big-font  tag label">{{$spec['content']}}</div>
                    @endif
                @endforeach
            </div>

            <div class="specs">
                @foreach( $product->spec as $spec)
                    @if($spec['level'] == 1)
                        <div>{{$spec['content']}}</div>
                    @endif
                @endforeach
            </div>

        </div>


        <div class="pos-spacing"></div>
        <div class="prod-price">
            <i class=" f-left minus large  icon teal icon-count "></i>
            <input class="f-left  big-font quantity" type="text" value="1"/>
            <i class="f-left  plus large icon red  icon-count"></i>
            <div class="f-right  total-price">
                总计:<strong class="huge-font">￥{{$product->price}}</strong>
            </div>
        </div>

        <div class="add-to-cart giant-font">
            加入购物车
        </div>


    </div>

    <div class="ui page dimmer">
        <div class="  dimmer-box" >
            <h3>已经加入了购物车</h3>

            <div class="ui buttons dimmer-btn "   >
                <button type="submit" class="ui teal button" >继续购物</button>
                <a class="or" data-text="<->"></a>
                <a class="ui teal  button" href="/weixin/cart" >购物车</a>
            </div>
        </div>
    </div>
@stop


@section('script')
    <script type="text/javascript">


    $("#slider").excoloSlider();
        $(document).ready(function(){

            $('.add-to-cart,.prod-price').css('width',$('.prod-detail-box').width());

            $('.plus').click(function(){

                var itemCount =   parseInt($('.quantity').val());
                $('.quantity').val(itemCount+1);
//                var itemCount = parseInt($('.icon-message-count').text());
//                itemCount +=1;
//                if(itemCount === 0)
//                {
//                    $('.icon-message-count').removeClass('none-display').fadeIn();
//                    $('.icon-message-count').text(itemCount);
//                }
//                else{
//                    $('.icon-message-count').text(itemCount);
//                }

            })

            $('.minus').click(function(){

                var itemCount =   parseInt($('.quantity').val());
                if(itemCount >= 0){
                    $('.quantity').val(itemCount-1);
                }
            })

            $('.add-to-cart').click(function (){
                $.ajax({
                    type: 'POST',
                    async : false,
                    url: '/weixin/addToCart',
                    dataType: 'json',
                    data:{productId:'{{$product->id}}',parentProductId:0},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success: function(data)
                    {
                        var status  = data.statusCode;

                        if(status ==1 )
                        {
                            var newitemCount =   parseInt($('.quantity').val());

                            var itemCount = parseInt($('.icon-message-count').text());

                            if(itemCount === 0)
                            {
                                $('.icon-message-count').removeClass('none-display').fadeIn();
                                $('.icon-message-count').text(itemCount+newitemCount);
                            }
                            else{
                                $('.icon-message-count').text(itemCount+newitemCount);
                            }

                            $('.dimmer')
                                    .dimmer('show',{closable:'false'})
                            ;
                        }
                        else{
                            alert('失败了');
                        }

                    },
                    error: function(xhr, type){
                        alert('Ajax error!')
                    }

                });
            })

        })
    </script>

@stop