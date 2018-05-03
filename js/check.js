
$(function(){
    $('.active').click(function () {
        $('.popup-ft .protocol').toggle();
        res();
    });
    $('.close').click(function () {
        $('.masked').hide();
    });
    $('.login').click(function () {
        $('.masked').show();
    });
    $('.field-hint').click(function () {
        $(this).siblings('input').focus();
    });
});
function checkUsername(obj) {
    var v = obj.val();
    var reg = /^[\da-zA-z]{6,12}$/;
    if ( !reg.test(v) || v == "") {
        obj.addClass("input-error");
        return false;
    }else {
        obj.removeClass("input-error");
        return true;
    }
}
function checkPassword(obj) {
    if(obj.val() == ''){
        obj.addClass("input-error");
        return false;
    } else {
        obj.removeClass("input-error");
        return true;
    }
}
function focusInput(obj) {
    obj.addClass("input-focus");
    obj.parent(".field").addClass("item-focus");
}


function loginCheck(){
    $('.login-btn').click(function(){
        var username = $('#username');
        var password = $('#password');
        var token = $('#token');
        var loginPath = $('#loginForm').attr('action');

        if (!checkUsername(username)){
            alert('请输入6-12位的用户名');
            username.focus();
            return false;
        }

        if(!checkPassword(password)){
            alert('请输入密码');
            password.focus();
            return false;
        }
        $.ajax({
            type : "POST",
            url : loginPath,
            data : {
                username : username.val(),
                password : password.val(),
                csrf_key : token.val()
            },
            success : function(data) {
                if ( data.status == 1 ) {
                    alert(data.msg);
                    window.location.reload(location.href);
                } else {
                    alert(data.msg);
                }
            },
            error: function() {
                alert('网络错误，，请稍后重试');
            }
        });
    });
}
loginCheck();
