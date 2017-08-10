<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .table th{
            text-align: center;
        }
    </style>
</head>
<body>
	<?php include './view/header.php' ?>
    <div class="container">
        <div class="row">
			<?php include './view/left.php' ?>

            <div class="col-lg-9">
                <!-- TAB NAVIGATION -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="active"><a href="<?php echo u('index')?>" role="tab" data-toggle="tab">班级列表</a>
                    </li>
                    <li><a href="<?php echo u('store')?>" role="tab" data-toggle="tab">添加/修改</a></li>
                </ul>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th width="100">id</th>
                        <th width="300">班级名</th>
                        <th width="200">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($data as $g): ?>

                        <tr style="text-align: center">
                            <td><?php echo $g['gid']?></td>
                            <td><?php echo $g['gname']?></td>
                            <td>
<!--                                点击切换至修改班级页面，这里需要传递一个参数，我们需要知道要修改哪个班级-->
                                <a href="<?php echo u('update').'&gid='.$g['gid']; ?>" class="btn btn-primary btn-sm">修改班级</a>
                                <a href="javascript:if(confirm('确定要删除吗？')) location.href='<?php echo u("remove") .'&gid='.$g["gid"]?>'" class="btn btn-danger btn-sm">删除班级</a>
                            </td>
                        </tr>
                        <?php endforeach;?>

                    </tbody>
                </table>
                <a href="<?php echo u('store')?>" class="btn btn-primary">添加班级</a>

            </div>

        </div>

    </div>

	<?php include './view/footer.php' ?>

    </body>
</html>