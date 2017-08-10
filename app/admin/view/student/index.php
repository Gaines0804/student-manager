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

        .table tr{
            line-height: 35px;
        }
        .table td{
            text-align: center;
        }
    </style>
	<?php include './view/header.php' ?>
    <div class="container">
        <div class="row">
			<?php include './view/left.php' ?>

            <div class="col-lg-9">
                <!-- TAB NAVIGATION -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="active"><a href="" role="tab" data-toggle="tab">学生列表</a>
                    </li>
                    <li><a href="<?php echo u('store');?>" role="tab" data-toggle="tab">添加/修改</a></li>
                </ul>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>id</th>
                        <th>姓名</th>
                        <th>头像</th>
                        <th>性别</th>
                        <th>出生日期</th>
                        <th>所在班级</th>
                        <th>自我介绍</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($data as $s):?>
                        <tr>
<!--                            显示id-->
                            <td><?php echo $s['sid']?></td>
<!--                            显示姓名-->
                            <td><?php echo $s['sname']?></td>
<!--                            显示头像-->
                            <td><img src="<?php echo $s['profile']?>" style="width: 50px;"></td>
<!--                            显示性别-->
                            <td><?php echo $s['sex']?></td>
<!--                            显示出生日期-->
                            <td><?php echo $s['birthday']?></td>
<!--                            显示班级-->
                            <td><?php echo $s['gname']?></td>
<!--                            显示自我介绍-->
                            <td width="240"><?php echo $s['introduction']?></td>
                            <td>
                                <a href="<?php echo u('update') . '&sid=' . $s['sid'] .'&gid='.$s['gid'];?>" class="btn btn-primary btn-xs">修改</a>
                                <a href="javascript: if(confirm('你要删除该学生的信息吗？')) location.href='<?php echo u('remove') . '&sid=' . $s['sid'];?>' " class="btn btn-danger btn-xs">删除</a>
                            </td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
                <a href="<?php echo u('store');?>" class="btn btn-primary">添加学生</a>
            </div>

        </div>

    </div>

	<?php include './view/footer.php' ?>

    </body>
</html>