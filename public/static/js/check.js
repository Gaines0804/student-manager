
$(function () {
    //注册页面检测用户名
    //1、定义函数dis
    //2、主要功能实现阻止提交按钮的默认状态，之后的焦点事件需要多次用到，这里定义为函数，之后只需要调用就能实现功能
    function dis() {
        $('button[name=reg]').attr('disabled', true);
    }
    //1、定义函数able
    //2、主要功能实现取消阻止提交按钮的默认状态，之后的焦点事件需要多次用到，只需要定义为函数，之后只需要调用就能实现功能
    function able() {
        $('button[name=reg]').attr('disabled', false);
    }
    //1、给输入添加焦点事件
    //2、焦点事件结合异步操作实现不刷新页面
    $('input[name=userName]').blur(function () {

        //1、获得用户输入的用户名
        //2、登录时候需要对用户名进行判断，判断用户名是否已被注册
        var userName = $(this).val();
        //1、获得用户名的长度
        //2、用来判断用户输入的用户名长度是否符合网站规定的长度
        var len = userName.length;
        //1、判断长度是否大于4
        //2、一般网站都很少出现简单的用户名，至少都要求4位字符
        if (len<4||userName==''){
            $('#userMsg').html('<span style="color:red;">用户名不得少于4位</span>');
        }else{
            //alert(uname);
            //1、异步检测
            //2、这样做的话避免了页面刷新，用户体验更好，不需要提交之后再判断用户名和密码是否符合要求
            $.ajax({
                //1、数据处理指向地址
                //2、需要将数据提交给一个页面或者方法来处理
                url: '?s=member/checkUserName',
                type: 'post',
                //1、提交的数据
                //2、需要将数据提交到给定的页面，才能处理
                data: {u: userName},
                //1、成功之后的返回函数
                //2、当数据处理成功之后需要获得一个反馈信息，然后对反馈回来的信息进一步处理
                success: function (phpData) {
                    if (phpData == 0) {
                        //1、提示信息
                        //2、当用户输入正确时候给用户一个反馈信息，让用户知道用户名是否可以注册，不需要等到点击按钮才判断
                        $('#userMsg').html('<span style="color:red;">用户名已存在</span>');
                    } else if (phpData == 1) {
                        //1、改变提示框的信息
                        //2、当用户输入正确时候给用户一个反馈信息，让用户知道用户名是否可以注册
                        $('#userMsg').html('<span style="color:#209fdc;">用户名可用</span>');
                    }
                }
            })
        }

    });//input:name=userName
    //1、获得焦点事件
    //2、当获得焦点时，恢复或者是显示正常状态下的提示信息
    $('input[name=userName]').focus(function () {
        $('#userMsg').html('<span style="color:red;">*</span>');
    });//input:name=userName
    //注册页面检测用户名结束


    //注册页面检测密码和重复密码
    $('input[name=pwd]').blur(function () {
        //1、定义一个正则表达式
        //2、用来检验用户输入的密码是否符合我们的要求
        var pwdReg = /[0-9A-Za-z_!]{6,16}/;//8到16位数字与字母组合
        //1、获得用户输入的密码
        //2、需要通过正正则表达式来检测密码是否符合要求
        var pwd = $(this).val();
        if(!pwdReg.test(pwd)){
            //1、反馈信息
            //2、给用户提示信息，让用户知道为什么密码不符合
            $('#pwdMsg').html('<span style="color:red;">密码必须是6-16位</span>');
        }else{
            //1、反馈信息
            //2、给用户提示信息，让用户知道密码是否符合我们给定的要求
            $('#pwdMsg').html('<span style="color:#209fdc;">√</span>');
        }
    });
    //1、重复密码检测
    //2、只有当两次密码相等时，才能注册，为了防止机器识别，向数据库中写入大量的无意义的数据
    $('input[name=repwd]').blur(function () {
        if($(this).val()!=$('input[name=pwd]').val()){
            //1、如果两次密码不一致时反馈信息
            //2、提示用户，交互性更好，不需要等到提交时才判断
            $('#repwdMsg').html('<span style="color:red;">两次密码不一致</span>');
        }else if($(this).val()==''){
            $('#repwdMsg').html('<span style="color:red;">请再次输入密码</span>');
        }else {
            $('#repwdMsg').html('<span style="color:#209fdc;">√</span>');
        }
    });
    //检测密码和重复密码结束

    //注册页面检测验证码
    $('input[name=code]').blur(function () {
        //1、获得用户输入的code验证码
        //2、需要用到用户输入的验证码与session中的验证码进相比对
        var code = $(this).val();
        //1、异步检测
        //2、这样做的话避免了页面刷新，用户体验更好，不需要提交之后再判断验证码是否符合要求
        $.ajax({
            url:'?s=member/checkCode',
            type:'post',
            //1、提交的数据
            //2、需要将数据提交到给定的页面，才能处理
            data:{c:code},
            //1、成功之后的返回函数
            //2、当数据处理成功之后需要获得一个反馈信息，然后对反馈回来的信息进一步处理
            success:function (phpCode) {
                if(phpCode==1){
                    //1、改变提示框的信息
                    //2、当用户输入正确时候给用户一个反馈信息，让用户知道是否可以点击注册
                    $('#codeMsg').html('<span style="color:#209fdc;">√</span>');
                    //1、恢复按钮的默认状态
                    //2、如果用户填写的验证码正确就同意让用户注册
                    able();
                }else{
                    //1、改变提示框的信息
                    //2、这样给用户一个反馈信息，让用户知道哪里出错，界面交互更友好，更智能
                    $('#codeMsg').html('<span style="color:#FF0000;">验证码错误</span>');
                    //1、阻止按钮的默认状态
                    //2、如果密码错误就不让用户登录，阻止按钮状态
                    dis();
                }
            }
        })
    });
});