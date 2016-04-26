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

    <div class="ui  container login-box" style=" overflow:hidden;" >


        <img  src="../img/login_cover.jpg " class="blur" style="width:100%; height:700px;">ZA
        <form method="POST"  onsubmit=" return checkReset()" id="resetPasswordForm">
            {!! csrf_field() !!}
            <div class="login-box-mask big-font">

                <div  class="box-content ">


                    <p class="giant-font">修改密码</p>

                    <div class="ui  left icon input login-input-box">
                        <input class="login-reg-input transparent-input" name="mobile" id="mobile" type="text" placeholder="手机号/用户名" value="{{ old('mobile') }}">
                        <i class="users icon" style="color:white"></i>
                    </div>

                    <div class="ui input reg-input-box">
                        <input class="login-reg-input transparent-input" name="verifySmsCode" id="verifySmsCode" type="text" placeholder=" 验证码">
                        <div class="long-btn blue-btn" id="sendVerifySmsCode">
                            发送验证码
                        </div>
                    </div>

                    <div class="ui  left icon input login-input-box">
                        <input  class="login-reg-input transparent-input" name="newPassword" id="newPassword" type="password" placeholder="新密码">
                        <i class="lock icon" style="color:white"></i>
                    </div>

                    <div class="ui buttons login-btn-box" >
                        <div id="submit"   class="ui teal button">确认修改</div>
                    </div>
                </div>
            </div>
        </form>

        <div class="ui page dimmer">
            <div class="  dimmer-box" >
                <h3>密码修改成功</h3>

                <div class="ui buttons dimmer-btn "   >
                    <a class="ui teal  button" href="/auth/login" >前往登录</a>
                </div>
            </div>
        </div>



    </div>
@stop


@section('script')
    <script type="text/javascript">


        function checkReset()
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
            else if ($.trim($('#verifySmsCode').val())==='')
            {

                _showToaster('短信验证码不能为空');

                return false;
            }
            else if ($.trim($('#newPassword').val())==='')
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
                _showToaster('输入的验证码不正确');
            }



            //手机号码检查
            function checkMobile(obj )
            {
                var status = 0;

                if($.trim($('#mobile').val()) === '')
                {
                    _showToaster('手机号不能为空');
                    status =  4;
                }
                else if (!(new RegExp("^1[0-9]{1}[0-9]{9}$")).test($.trim($('#mobile').val())))
                {

                    _showToaster('手机格式错误');
                    status =  3;

                    return status;
                }
                else {

                    $.ajax({
                        type: 'POST',
                        async: false,
                        url: '/authCheck/CheckMobile',
                        data: {mobile: $.trim($('#mobile').val())},
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        },
                        success: function (data) {
                            status = data.statusCode;

                            if (status ===1 ) {
                                _showToaster('帐号不存在');
                                //obj.siblings('.icon').removeClass('check').addClass('remove').fadeIn();

                            }

                        },
                        error: function (xhr, type) {
                            alert('Ajax error!')
                        }

                    });
                }
                return status;
            }



            var countdown=60;//倒计时60秒
            function settime(obj) {


                if (countdown == 0) {

                    obj.removeClass('code-send');
                    obj.text("再次发送");
                    countdown = 60;
                    return;
                } else {

                    obj.text(countdown+'秒后可重发' );
                    countdown--;
                }
                setTimeout(function() {
                            settime(obj) }
                        ,1000)
            }


            //发送验证码
            $('#sendVerifySmsCode').click(function(){

                var sendBtn = $(this);

                if(countdown !== 60)
                    return;

                //检查手机号
                var mobileStatus = checkMobile($('#mobile'));

                //如果手机号码不是已经注册的号码 或是空
                if(mobileStatus !==2)
                {
                    return;
                }
                else{
                                //发送短信
                        $.ajax({
                                    type: 'POST',
                                    async:false,
                                    url: '/sendSmsCode',
                                    data: { mobile : $.trim($('#mobile').val()),type:2},
                                    dataType: 'json',
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                                    },
                                    success: function(data)
                                    {


                                        if(data.statusCode === 1)
                                        {
                                            //验证码发送成功
                                            sendBtn.addClass('code-send');
                                            settime(sendBtn);
                                        }
                                        else
                                        {

                                            _showToaster(data.extra.msg);
                                            //todo 判断发送验证码失败的原因 第三方
                                        }

                                    },
                                    error: function(xhr, type){
                                        alert('Ajax error!')
                                    }

                                });
                    }
                });


            $('#submit').click(function (){
                $.ajax({
                    url:"/auth/setPassword",
                    data:$("#resetPasswordForm").serialize(),
                    type:"post",
                    dataType:'json',
                    success:function(data){
                        if(data.statusCode == 1)
                        {
                            $('.dimmer').dimmer('show',{closable:'false'})
                        }
                        else {

                            _showToaster(data.statusMsg);
                        }

                    },
                    error: function (xhr, type) {
                    }
                });
            });

        })
    </script>
@stop