<link rel="stylesheet" href="./static/bt/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-inverse" style="border-radius: 0">
	<div class="container">
		<a class="navbar-brand" href="">Student Manager</a>
		<ul class="nav navbar-nav" style="float: right;">
            <li class="active" >
                <a href="<?php echo u('home/entry/index')?>">首页</a>
            </li>
            <?php if(isset($_SESSION['user'])): ?>
            <li  class="active" >
                <a href="<?php echo u('admin/entry/index')?>">后台</a>
            </li>
            <?php endif; ?>

			<li>
                <?php if(isset($_SESSION['user'])): ?>
                    <a href="<?php echo u('admin/user/logout') ?>"><span style="color: red"><?php echo $_SESSION['user']['username'] ?></span>&nbsp;&nbsp;退出</a>
                <?php else:?>
                    <a href="<?php echo u('admin/user/login')?>">登录</a>
                <?php endif;?>
			</li>
		</ul>

	</div>
</nav>