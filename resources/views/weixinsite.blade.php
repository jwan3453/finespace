
<!DOCTYPE html/>
<html>
<head>
    <meta charset="utf-8">
    <meta name=”viewport” content=”width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;” />
    <meta name=”viewport” content=”width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=false;” />
    <meta name=”viewport” content=”width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=no;” />
    <meta name="viewport" content="width=device-width, user-scalable=no" />
    <meta name="_token" content="{{ csrf_token() }}"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <link rel="stylesheet" type="text/css" href= {{ asset('semantic/dist/semantic.css') }}>
    <link rel="stylesheet" type="text/css" href= {{ asset('css/weixin.css') }}>
    <script src={{ asset('js/jquery-2.1.4.min.js') }}></script>
    <script src={{ asset('semantic/dist/semantic.js') }}></script>

    @yield('resources')

</head>


<body>
    <div class="ui bottom  demo vertical  sidebar labeled icon menu side-menu " >
        <a class="item "  href="/weixin">
            <i class="home icon"></i>
            凡悦
        </a>
        <a class="item"  href="/weixin/member">
            <i class="user icon"></i>
            个人中心
        </a>
        <a class="item "  href="/weixin/cart">
            <i class="add to cart icon  icon"></i>
            购物车
        </a>

        <a class="item "  href="/weixin/store">
            <i class="grid layout icon"></i>
            凡悦门店
        </a>
    </div>

    <div class=" pusher ui container" >



        <div class="pos-spacing">
        </div>

        <div class="home-header auto-margin ">
            <div class="side-menu-icon f-left"></div>


            <div class="icon-menu f-right  ">
                <a class="item icon-anchor header-cart-icon" href="/weixin/cart" >
                    <i class="cart icon big  " id="cartIcon"></i>
                    <span class="none-display big-font icon-message-count">0</span>
                </a>
            </div>


            <div class="icon-menu f-right ">
                <a class="item icon-anchor" href="/auth/login"><i class="user icon big  "></i>

                </a>
            </div>

        </div>

        @yield('content')
    </div >

    <div class="toaster-box big-font ">
        <div class="toaster "></div>
    </div>
</body>


@yield('script')

<script type="text/javascript">



    //从cookie 和数据中获得购物车商品数量
    function _getCartCookie(){
        $.ajax({
            type: 'POST',
            async : false,
            url: '/weixin/getCartCookie',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            success: function(data)
            {
                var itemCount  = data.statusCode;
                if(itemCount != 0  )
                {
                    var itemCountMsgObj = $('.icon-message-count');
                    itemCountMsgObj.removeClass('none-display').fadeIn().text(itemCount);

                }

            },
            error: function(xhr, type){
                alert('Ajax error!')
            }

        });
    }

    function _showToaster($message){
        $('.toaster').text($message).fadeIn(500).fadeOut(2500 );
    }


    $(document).ready(function(){


        $('.container').css('min-height',$(document).height()).css('background-color','white');
//
        $('.home-header').css('width',$('.container').width());

        $('.home-header').offset({left:$('.container').offset().left});
        $(window).resize(function(){
            $('.home-header').css('width',$('.container').width());

            $('.home-header').offset({left:$('.container').offset().left});
        });

        _getCartCookie();
        $('.side-menu-icon').click(function(){
            $('.ui.labeled.icon.sidebar')
                .sidebar('toggle')
            ;
        })

        //get cart detail

    })
</script>

</html>
