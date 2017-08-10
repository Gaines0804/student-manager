<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>附件</title>
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
                    <li class="active"><a href="<?php echo u('index')?>" role="tab" data-toggle="tab">附件列表</a>
                    </li>
                </ul>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th width="100">id</th>
                        <th width="100">附件</th>
                        <th>附件路径</th>
                        <th>创建时间</th>
                        <th width="200">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($data as $a): ?>
                        <tr style="text-align: center">
                            <td><?php echo $a['aid']?></td>
                            <td><img src="<?php echo $a['path']?>" width="50"></td>
                            <td><?php echo $a['path']?></td>
                            <td><?php echo date('Y-m-d H:i:s',$a['createtime'])?></td>
                            <td>
                                <a href="javascript:if(confirm('您要删除附件吗？')) location.href='<?php echo u('remove') .'&aid='.$a['aid'].'&path='.$a['path']?>'" class="btn btn-danger btn-xs">删除附件</a>
                            </td>
                        </tr>
                        <?php endforeach;?>

                    </tbody>
                </table>
            </div>

        </div>

    </div>

	<?php include './view/footer.php' ?>

    </body>
</html>