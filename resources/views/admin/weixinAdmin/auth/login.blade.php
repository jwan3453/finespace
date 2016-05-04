<!DOCTYPE html>
<html>
<head>
    <meta name="_token" content="{{ csrf_token() }}"/>
    <title></title>
    <link rel="stylesheet" type="text/css" href= {{ asset('semantic/dist/semantic.css') }}>
    <link rel="stylesheet" type="text/css" href= {{ asset('css/weixin.css') }}></head>

    <script src={{ asset('js/jquery-2.1.4.min.js') }}></script>
    <script src={{ asset('semantic/dist/semantic.js') }}></script>
<body>
    <div class="ui container" style=" overflow:hidden;" id="homepage">
        <div class="sign-box auto-margin" >
            <div class="box-header">
                <a class="ui red ribbon label">凡悦后台管理登录</a>

            </div>

            <div class="box-content">
                <form class="ui form">
                    <div class="field">
                        <label>用户名</label>
                        <input type="text" name="username" placeholder="用户名"></div>
                    <div class="field">
                        <label>密码</label>
                        <input type="password" name="password" placeholder="密码"></div>

                    <a class="sign-button ui button" onclick="ToSubmit()">登录</a>
                </form>

            </div>

        </div>

    </div>

    <div class="ui modal" id="content-msg"> <i class="close icon" id="close-i"></i>
        <div class="header">提示</div>
        <div id="category-form" class="image content">
            <div class="content" id="content"></div>

        </div>
        <div class="actions">
            <div class="ui positive right  button" id="refresh">确定</div>
        </div>
    </div>
</body>

    <script type="text/javascript">
    
    function ToSubmit() {
        $.ajax({
            type: 'POST',
            url: '/weixin/admin/Sign',
            data: $('.form').serialize(),
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            success: function(data){
                $("#content").html(data.Msg);
                $("#content-msg").modal('show');
                if (data.status == 1) {
                    window.location.href="/weixin/admin";
                }
            },
            error: function(xhr, type){
                alert('Ajax error!')
            }
        });
    }
</script>

</html>