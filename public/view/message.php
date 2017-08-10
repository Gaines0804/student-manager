<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>消息提示页面</title>
    <link rel="stylesheet" href="./static/bt/css/bootstrap.min.css">
</head>
<body style="background: #eee">
<div class="jumbotron" style="text-align: center;margin-top: 100px;">
    <h1><?php echo $msg; ?></h1>
    <p>
        <a href="javascript:<?php echo $this->url ?>;" style="font-size: 16px;">如果还未跳转，请点击我调转</a>
    </p>
    <p><a class="btn btn-primary btn-lg" href="http://nickblog.cn" role="button">Homepage</a></p>
</div>
<script>
    setInterval(function () {
        <?php echo $this->url; ?>
    },1000)
</script>
</body>