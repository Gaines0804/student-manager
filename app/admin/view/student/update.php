<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script type="application/javascript" src="./static/js/jquery.min.js"></script>
    <script>
        $(function () {
            //点击显示素材
            $('#showAttachment').click(function () {
                $('#attachmentBox').toggle(200);
            });
            //给选中的素材添加样式
            $('#attachmentBox img').click(function () {
                $(this).css({"opacity":"0.7","border":"2px solid red"}).siblings().css({'opacity':'1','border':'none'});
                //将图片的地址写入隐藏域中
                $('input[name=profile]').val($(this).attr('src'));
            })

        })
    </script>
	<?php include './view/header.php' ?>
    <div class="container">
        <div class="row">
			<?php include './view/left.php' ?>
            <div class="col-lg-9">
                <!-- TAB NAVIGATION -->
                <ul class="nav nav-tabs" role="tablist">
                    <li><a href="<?php echo u('index');?>" role="tab" data-toggle="tab">学生列表</a></li>
                    <li class="active"><a href="<?php echo u('store');?>" role="tab" data-toggle="tab">添加/修改</a>
                    </li>
                </ul>
                <form action="" method="post" role="form" style="margin-top: 20px;" enctype="multipart/form-data">
                    <div class="form-group">
                        <select name="gid" class="form-control" required>
                            <option value="">请选择所在班级</option>
							<?php foreach ($grade as $g):?>
                                <option value="<?php echo $g['gid']?>" <?php if($g['gid']==$_GET['gid']): ?>selected<?php endif; ?>><?php echo $g['gname']?></option>
							<?php endforeach;?>
                        </select>
                    </div>
<!--                    姓名-->
                    <div class="form-group">
                        <input type="text" class="form-control" name="sname" id="" placeholder="name"
                               value="<?php echo $student[0]['sname']?>" required>
                    </div>
<!--                    素材区域-->
                    <div class="form-group">
                        <input type="file" name="profileupload" class="form-control" >
                        <input type="hidden" name="profile" value="<?php echo $student[0]['profile'] ?>">
                        <a href="javascript:;" class="btn btn-xs btn-info" style="margin-top: 10px;" id="showAttachment">显示/隐藏素材</a>
                        <div style="margin-top: 20px;display: block" id="attachmentBox">
                            <?php foreach ($attachment as $v): ?>
                                <img width="100" src="<?php echo $v['path'] ?>" <?php if($v['path']==$student[0]['profile']):?>style="opacity: 0.8;border: 2px solid red;" <?php endif;?>>
                            <?php endforeach; ?>
                        </div>
                    </div>
<!--                    性别-->
                    <div class="form-group">
                        <div class="radio ">
                            <label class="radio-inline">
                                <input type="radio" name="sex" value="男" <?php if($student[0]['sex']=='男'): ?>checked<?php endif;?>>
                                男
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="sex" value="女" <?php if($student[0]['sex']=='女'): ?>checked<?php endif;?> >
                                女
                            </label>
                        </div>
                    </div>
                    <div class="form-group" style="width: 260px">
                        <input type="date" name="birthday" class="form-control" value="<?php echo $student[0]['birthday']?>" required>
                    </div>
                    <div class="form-group">
                        <textarea name="introduction" placeholder="introduce yourself" cols="30" rows="6" class="form-control"><?php echo $student[0]['introduction']?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">保存修改</button>
                </form>
            </div>

        </div>

    </div>
	<?php include './view/footer.php' ?>


    </body>
</html>