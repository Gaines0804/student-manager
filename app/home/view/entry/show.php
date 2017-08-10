<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
	      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
    <style>
        table td{
            color: #5e5e5e;
        }
    </style>
	<?php include './view/header.php' ?>
	<div class="container" style="width: 600px">
		<ol class="breadcrumb">
			<li><a href="<?php echo u('index') ?>">首页</a></li>
			<li class="active"><?php echo $stuData[0]['sname'] ?></li>
		</ol>
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><?php echo $stuData[0]['sname'] ?></h3>
			</div>
			<div class="panel-body" style="padding: 20px">
				<table class="table table-hover">
					<tr>
						<th width="150">头像:</th>
						<td>
                            <img width="80" src="<?php echo $stuData[0]['profile'] ?>" alt="">
						</td>
					</tr>
					<tr>
						<th>性别:</th>
						<td>
                            <?php echo $stuData[0]['sex'] ?>
						</td>
					</tr>
					<tr>
						<th>出生日期:</th>
						<td>
                            <?php echo $stuData[0]['birthday'] ?>
						</td>
					</tr>
					<tr>
						<th>班级:</th>
						<td>
                            <?php echo $stuData[0]['gname'] ?>
                        </td>
					</tr>

					<tr>
						<th>自我介绍:</th>
						<td>
                            <?php echo $stuData[0]['introduction'] ?>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>

	<?php include './view/footer.php' ?>

	</body>
</html>