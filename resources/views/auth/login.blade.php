@extends('weixinsite')

@section('content')




    <div class="ui  container login-box" style=" overflow:hidden;" id="homepage">

        <img  src="../img/login_cover.jpg/ " style="width:100%; height:700px;">

        <form method="POST" action="{{url('auth/login')}}">
            {!! csrf_field() !!}
            <div class="login-box-mask huge-font">

                <div  class="box-content ">
                    <span class="giant-font slogan">凡悦 - fine space</span>
                    <p class="big-font">Place To Get You Mind Off</p>
                    <div class="ui  left icon input login-input-box">
                        <input class="login-reg-input transparent-input" name="mobile" type="text" placeholder="手机号/用户名">
                        <i class="users icon" style="color:white"></i>
                    </div>
                    <div class="ui  left icon input login-input-box">
                        <input  class="login-reg-input transparent-input" name="password" type="text" placeholder="密码">
                        <i class="lock icon" style="color:white"></i>
                    </div>

                    <div class="ui buttons login-btn-box" >
                        <button type="submit" class="ui teal button">登录</button>
                        <a class="or" data-text="<->"></a>
                        <a class="ui black  basic button" href="/auth/register">注册</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
@stop


@section('script')
    <script type="text/javascript">
        $(document).ready(function(){
            $('.pos-spacing,.home-header').hide();
            $('img').addClass('blur');
            $('.box-content').transition('swing down');
        })
    </script>
@stop