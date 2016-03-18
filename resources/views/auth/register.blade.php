@extends('weixinsite')

@section('content')




    <div class="ui  container " style=" overflow:hidden;" id="homepage">

        <img  src="../img/reg_cover.jpg/" style="width:100%; height:700px;" class="bg-img">
        <form method="POST"  action="{{url('auth/register')}}" id="registerForm">
            {!! csrf_field() !!}
            <div class="reg-box-mask big-font">

                <div  class="box-content ">

                    <p class="giant-font">用户注册</p>
                    <div class="ui icon input reg-input-box">
                        <input class="login-reg-input transparent-input" name="mobile"  id="mobile" type="text" placeholder="手机号">
                        <i class=" check  icon large"></i>

                    </div>

                    {{--<div class="ui input reg-input-box">--}}
                        {{--<input class="login-reg-input transparent-input" name="name" type="text" placeholder=" 用户名">--}}

                    {{--</div>--}}


                    <div class="ui icon input reg-input-box">
                        <input  class="login-reg-input transparent-input" name="password" id="password" type="password" placeholder=" 密码">
                        <i class=" check  icon large"></i>
                    </div>

                    <div class="ui icon input reg-input-box">
                        <input  class="login-reg-input transparent-input" name="password_confirmation" id="passwordConfirmation" type="password" placeholder=" 重复密码">
                        <i class=" check  icon large"></i>
                    </div>


                    <div class="ui action  input reg-input-box">
                        <input class="login-reg-input transparent-input" name="validateCode" type="text" placeholder="图片验证码">

                        <div style="width: 150px;">
                            <img src ='/getValidateCode' id="validateCode" style="width:100%;height:40px;">
                        </div>


                    </div>

                    <div class="ui input reg-input-box">
                        <input class="login-reg-input transparent-input" name="verifySmsCode" id="verifySmsCode" type="text" placeholder=" 验证码">
                        <div class="long-btn " id="sendVerifySmsCode">
                            发送验证码
                        </div>
                    </div>



                    <div class="ui buttons login-btn-box" >
                        <button type="submit" class="ui teal button submit">注册</button>
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
            $('.bg-img').addClass('blur');
            $('.box-content').transition( {
                animation : 'fly left',
                duration  : 800
            });

            $('#validateCode').click(function(){
                    $(this).attr('src','/getValidateCode?random' + Math.random() );
            })




            var countdown=60;//倒计时60秒
            function settime(obj) {


                if (countdown == 0) {

                    obj.removeClass('code-send');
                    obj.text("再次发送");
                    countdown = 60;
                    return;
                } else {

                    obj.text(countdown+'秒后,重新发送' );
                    countdown--;
                }
                setTimeout(function() {
                            settime(obj) }
                        ,1000)
            }



            //检查手机号
            //手机号码检查
            function checkMobile(obj )
            {
                var status = 0;
                $.ajax({
                    type: 'POST',
                    async : false,
                    url: '/authCheck/checkMobile',
                    data: { mobile : $.trim($('#mobile').val())},
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success: function(data)
                    {
                        status = data.statusCode;

                        if(status === 1 || status ===2)
                        {
                            $('.toaster').text(data.statusMsg);
                            $('.toaster').fadeIn(1000).fadeOut(1000 );
                            obj.siblings('.icon').removeClass('check').addClass('remove').fadeIn();

                        }
                        else{
                            obj.siblings('.icon').removeClass(' remove').addClass('check').fadeIn();
                        }
                    },
                    error: function(xhr, type){
                        alert('Ajax error!')
                    }

                });
                return status;
            }

            $('#mobile').change(function() {


                checkMobile($(this));
            });

            $('#password').change(function() {
                //检查密码是否符合规则
                //todo 加强密码规则
                var passwordRegex = new RegExp("^[0-9a-zA-Z_]{6,12}$");
                if (!passwordRegex.test($(this).val()))
                {
                    $('.toaster').text('密码必须是6到12位,字母与数据组合');
                    $('.toaster').fadeIn(1000).fadeOut();
                    $(this).siblings('.icon').removeClass('check').addClass('remove').fadeIn();
                }
                else{
                    $(this).siblings('.icon').removeClass(' remove').addClass('check').fadeIn();
                }


            });

            $('#passwordConfirmation').change(function(){

                if($('#password').val() !== $(this).val())
                {
                    $('.toaster').text('密码不一致,请重新输入');
                    $('.toaster').fadeIn(1000).fadeOut();
                    $(this).siblings('.icon').removeClass('check').addClass('remove').fadeIn();
                }
                else{
                    $(this).siblings('.icon').removeClass(' remove').addClass('check').fadeIn();
                }
            })




            //发送验证码
            $('#sendVerifySmsCode').click(function(){

                var sendBtn = $(this);

                if(countdown !== 60)
                    return;


                var mobileStatus = 2;//checkMobile();


                if(mobileStatus===1 ||  $('#mobile').val() == '')
                {
                    $('#invalidTelNumber').fadeOut().fadeIn();
                    sendBtn.attr('disabled', 'disabled');
                }
                else{
                    //发送短信
                    $.ajax({
                        type: 'POST',
                        async:false,
                        url: '/sendSmsCode',
                        data: { mobile : $.trim($('#mobile').val())},
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        },
                        success: function(data)
                        {


                            if(data.statusCode === 0)
                            {

                                sendBtn.addClass('code-send');
                                settime(sendBtn);
                            }
                            else
                            {
                                //todo 判断发送验证码失败的原因 第三方
                            }

                        },
                        error: function(xhr, type){
                            alert('Ajax error!')
                        }

                    });


                }

            })


        })
    </script>
@stop