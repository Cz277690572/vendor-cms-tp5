
// 判断是否已经登录
if(window.base.getLocalStorage('token')){

    var params = {
        url: 'token/verify',
        type: 'post',
        data:{token:window.base.getLocalStorage('token'),tokenFlag:false},
        sCallback:function (res) {
            // 校验令牌是否有效 isValid(Boolean)
            if (res.isValid){
                window.location.href = '/admin.html';
            }
        },
        eCallback:function (res) {
            // 异常处理
        }
    }
    window.base.getData(params);
}

$(function () {

    $(document).on('click','#login',function(){
        var $userName=$('#user-name'),
            $pwd=$('#user-pwd');
        if(!$userName.val()) {
            $userName.next().show().find('div').text('请输入用户名');
            return;
        }
        if(!$pwd.val()) {
            $pwd.next().show().find('div').text('请输入密码');
            return;
        }
        var params={
            url:'token/app',
            type:'post',
            data:{ac:$userName.val(),se:$pwd.val()},
            sCallback:function(res){
                if(res){
                    window.base.setLocalStorage('token',res.token);
                    window.location.href = '/admin.html';
                }
            },
            eCallback:function(e){
                if(e.status==401){
                    $('.error-tips').text('帐号或密码错误').show().delay(2000).hide(0);
                }
            }
        };
        window.base.getData(params);
    });

    $(document).on('focus','.normal-input',function(){
        $('.common-error-tips').hide();
    });

    $(document).on('keydown','.normal-input',function(e){
        var e = event || window.event || arguments.callee.caller.arguments[0];
        if(e && e.keyCode==13){
            $('#login').trigger('click');
        }
    });



});