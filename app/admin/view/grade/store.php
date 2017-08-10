<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
	      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
	<?php include './view/header.php' ?>
    <div class="container">
        <div class="row">
			<?php include './view/left.php' ?>
        <div class="col-lg-9">
            <!-- TAB NAVIGATION -->
            <ul class="nav nav-tabs" role="tablist">
                <li ><a href="<?php echo u('index')?>" role="tab" data-toggle="tab">班级列表</a></li>
                <li class="active"><a href="<?php echo u('store')?>" role="tab" data-toggle="tab">添加/修改</a></li>
            </ul>
            <form action="" method="post" role="form" style="margin-top: 20px;">

                <div class="form-group">
                    <input type="text" class="form-control" name="gname" id="" placeholder="grade name" value="">
                </div>
                <button type="submit" class="btn btn-primary">添加班级</button>
                <a href="<?php echo u('index')?>" class="btn btn-warning">取消添加</a>
            </form>
        </div>

    </div>

</div>
	<?php include './view/footer.php' ?>


</body>
</html>