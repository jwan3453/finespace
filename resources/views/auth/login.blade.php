@extends('weixinsite')

@section('content')


    @if (count($errors) > 0)
        <div class="none-display" >
            <ul style="color:red;">
                @foreach ($errors->all() as $error)
                    <li class="errorMessage none-display">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="ui  container login-box" style=" overflow:hidden;" id="homepage">

        <img  src="../img/login_cover.jpg " class="blur" style="width:100%; height:700px;">

        <form method="POST" action="{{url('auth/login')}}" onsubmit=" return checkLogin()">
            {!! csrf_field() !!}
            <div class="login-box-mask big-font" >

                <div  class="box-content  " >
                    <span class="giant-font slogan">凡悦 - fine space</span>
                    <p class="big-font">Place To Get You Mind Off</p>
                    <div class="ui  left icon input login-input-box" >
                        <input class="login-reg-input transparent-input" name="mobile" id="mobile" type="text" placeholder="手机号/用户名" value="{{ old('mobile') }}">
                        <i class="users icon" style="color:white"></i>
                    </div>
                    <div class="ui  left icon input login-input-box">
                        <input  class="login-reg-input transparent-input" name="password" id="password" type="password" placeholder="密码">
                        <i class="lock icon" style="color:white"></i>
                    </div>

                    <div class="login-opts " >

                        <div class="ui checkbox f-left">
                            <input type="checkbox" name="remember">
                            <label>记住密码</label>
                        </div>

                        <a href="/auth/resetPassword" class="small-btn f-right">
                                忘记密码
                        </a>

                    </div>

                    <div class="ui buttons login-btn-box" >
                        <button type="submit"   class="ui teal button">登录</button>
                        <a class="or" data-text="-"></a>
                        <a class="ui black  basic button" href="/auth/register">注册</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
@stop


@section('script')
    <script type="text/javascript">


        function checkLogin()
        {

            if($.trim($('#mobile').val()) === '')
            {
                _showToaster('手机号不能为空');
                return false;
            }
            else if (!(new RegExp("^1[0-9]{1}[0-9]{9}$")).test($.trim($('#mobile').val())))
            {

                _showToaster('手机号格式错误');

                return false;
            }
            else if ($.trim($('#password').val())==='')
            {

                _showToaster('密码不能为空');

                return false;
            }
           return true;
        }

        $(document).ready(function(){
            $('.pos-spacing,.home-header').hide();
            $('img').addClass('blur');
            $('.box-content').transition('swing down');

            if($('.errorMessage').hasClass('errorMessage') !== false)
            {
                _showToaster('用户名或密码不正确');
            }



        })
    </script>
@stop