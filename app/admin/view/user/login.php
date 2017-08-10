<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
	      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
    <script src="./static/js/jquery.min.js"></script>
	<?php include './view/header.php' ?>
<div class="container" style="width: 600px">
    <ol class="breadcrumb">
        <li><a href="<?php echo u('home/entry/index'); ?>">首页</a></li>
        <li class="active">登录</li>
    </ol>

	<form method="post" action="">
		<div class="form-group">
			<label for="">用户名</label>
			<input type="text" class="form-control" id="" placeholder="username" name="username" required>
		</div>
		<div class="form-group">
			<label for="">密码</label>
			<input type="password" class="form-control" id="" placeholder="Password" name="password" required>
		</div>
        <div class="form-group">
            <label for="">验证码</label>
            <input type="text" class="form-control" id="" placeholder="captcha" name="captcha" required>
        </div>
        <div class="form-group">
            <img name="captcha" src="<?php echo u('captcha') . '&mt=' . microtime(true) ?>" onclick="this.src=this.src+'mt='+Math.random()">
            <span id="captchaMsg"></span>
        </div>
		<div class="checkbox">
			<label>
				<input type="checkbox" name="autologin"> 记住我，七天免登陆
			</label>
		</div>

        <div style="text-align: center">
            <button name="login" type="submit" class="btn btn-primary">管理员登录</button>
        </div>
	</form>
</div>

	<?php include './view/footer.php' ?>


    <script>
        $(function () {
            $('img[name=captcha]').click(function () {
                $('button[name=login]').attr('disabled', true);
                $('#captchaMsg').html('<span style="color:#FF0000;">验证码错误</span>');
            });
            //1、校验验证码
            //2、需要校验验证码，才能让用户登录，如果不校验就会被机器识别，大量的向数据库中写入无意义的数据
            $('input[name=captcha]').blur(function () {
                //1、获得用户输入的captcha验证码
                //2、需要将用户输入的验证码与session中的验证码比对
                var captcha = $(this).val();
                //1、异步处理
                //2、这样做的话避免了页面刷新，用户体验更好，不需要提交之后再判断用户名和密码是否正确
                $.ajax({
                    url:'<?php echo u('admin/user/checkCaptcha')?>',
                    type:'post',
                    data:{c:captcha},
                    success:function (phpData) {
                        if(phpData==1){
                            $('#captchaMsg').html('<span style="color:#209fdc;">验证码正确</span>');
                            $('button[name=login]').attr('disabled', false);
                        }else{
                            $('#captchaMsg').html('<span style="color:#FF0000;">验证码错误</span>');
                            $('button[name=login]').attr('disabled', true);
                        }
                    }
                })
            });
        })
    </script>
</body>
</html>