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

        <table class="table table-hover">
            <thead>
            <tr>
                <th>id</th>
                <th>头像</th>
                <th>姓名</th>
                <th>性别</th>
                <th>出生日期</th>
                <th>班级</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($stuData as $s): ?>
            <tr>
                <td><?php echo $s['sid'] ?></td>
                <td><img width="80" src="<?php echo $s['profile'] ?>" alt=""></td>
                <td><?php echo $s['sname'] ?></td>
                <td><?php echo $s['sex'] ?></td>
                <td><?php echo $s['birthday'] ?></td>
                <td><?php echo $s['gname'] ?></td>
                <td>
<!--                    跳转到显示页面，这里需要传递一个参数sid-->
                    <a href="<?php echo u('show').'&sid='.$s['sid']; ?>" class="btn btn-primary btn-xs">查看信息</a>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php include './view/footer.php' ?>
    </body>
</html>