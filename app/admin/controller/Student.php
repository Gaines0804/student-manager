<?php
//1、指定命名空间
//2、命名空间一个最明确的目的就是解决重名问题，PHP中不允许两个函数或者类出现相同的名字，否则会产生一个致命的错误。这种情况下只要避免命名重复就可以解决，最常见的一种做法是约定一个前缀。
namespace app\admin\controller;
use houdunwang\view\View;
use system\model\Student as studentModel;
use system\model\Grade;
use system\model\Attachment;

class Student extends Com {
    //1、学生信息列表
    //2、显示学生信息
    public function index(){
        //1、获得数据库中的数据
        //2、我们需要从数据库中拿到学生的信息，显示在页面中
        $data = studentModel::q("SELECT * FROM student AS s JOIN grade AS g ON s.gid=g.gid");
        //p($data);exit;
        //1、载入学生信息页面，将数数据通过with方法一同传入
        //2、这样页面中就可使用数据库中信息了
        return View::make()->with(compact('data'));
    }

    public function update(){
        //echo 123;exit;
        //1、获得对应的数据
        //2、我们修改数据时候需要知道修改那条数据，通过get参数来获得对应的数据
        $grade = Grade::get();
        $student = studentModel::where("sid={$_GET['sid']}")->get();
        //p($student);exit;
        $attachment = Attachment::get();
        //p($grade);exit;
        //p($attachment);exit;
        if(IS_POST){
            //1、获得学生姓名
            $sname = $_POST['sname'];
            //1、获得用户选择的图片的路径
            //2、我们需要将路径存放到附件表中，同时还需要在页面中显示图片
            if($_FILES['profileupload']['error'] != 4){
                //如果用户没有选择图片，即用户点击上传，那么就将用户上传的图片的路径赋值给变量
                $profile = $this->upload();
            }else{
                //如果用户选择了素材，那么此时隐藏域里面的value不为空，也就是$_POST不为空，那么就将隐藏域中的路径保存
                $profile = $_POST['profile'];
            }
            //获得性别
            $sex = $_POST['sex'];
            //获得出生日期
            $birthday = $_POST['birthday'];
            //获得自我介绍的内容
            $introduction =$_POST['introduction'];
            //获得班级gid，我们需要在显示页面的时候使用到班级
            $gid = $_POST['gid'];

            //1、组合修改信息的sql语句
            //2、我们需要通过sql语句来完成信息的修改
            $sql = "UPDATE student SET sname='{$sname}',profile='{$profile}',sex='{$sex}',birthday='{$birthday}',introduction='{$introduction}',gid={$gid} WHERE sid={$_GET['sid']}";
            //echo $sql;
            //1、执行无结果集
            //2、有了sql语句还需要执行才能完成修改
            studentModel::e($sql);

            //p($profile);
            //1、跳转到信息提示页面
            //2、添加成功之后会停留在空白页面，通过跳转到提示信息页面来解决
            $this->setRedirect(u('admin/student/index'))->message('修改成功');
        }

        return View::make()->with(compact('grade','attachment','student'));
    }

    public function store(){
        //1、获得班级信息
        //2、我们再添加学生的时候需要用选择班级
        $data = Grade::get();

        //1、获得附件数据
        //2、我们需要显示素材
        $attachment = Attachment::get();
        //1、判断是否为post提交
        //2、因为添加信息是在用户点击了按钮之后进行的
        if(IS_POST){
            //p($_POST);
            //1、获得用户提交过来的数据
            //2、我们需要将数据提交到数据库中

            //1、获得学生姓名
            $sname = $_POST['sname'];
            //1、获得用户选择的图片的路径
            //2、我们需要将路径存放到附件表中，同时还需要在页面中显示图片
            if($_FILES['profileupload']['error'] != 4){
                //如果用户没有选择图片，即用户点击上传，那么就将用户上传的图片的路径赋值给变量
                $profile = $this->upload();
            }else{
                //如果用户选择了素材，那么此时隐藏域里面的value不为空，也就是$_POST不为空，那么就将隐藏域中的路径保存
                $profile = $_POST['profile'];
            }
            //获得性别
            $sex = $_POST['sex'];
            //获得出生日期
            $birthday = $_POST['birthday'];
            //获得自我介绍的内容
            $introduction =$_POST['introduction'];
            //获得班级gid，我们需要在显示页面的时候使用到班级
            $gid = $_POST['gid'];

            //1、组合sql语句
            //2、我们需要通过sql语句将数据插入到数据库中
            $sql = "INSERT INTO student (sname,profile,sex,birthday,introduction,gid) VALUES ('{$sname}','{$profile}','{$sex}','{$birthday}','{$introduction}',{$gid})";
            //echo $sql;

            //1、执行无结果集e方法
            //2、有了sql语句还需要执行，才能完成数据的写入
            studentModel::e($sql);

            $this->setRedirect(u('admin/student/index'))->message('添加成功');
        }
        //1、载入模板页面
        //2、添加需要通过页面输入信息，这里传了数据，我们添加学生信息时候需要选择班级，所以需要将班级表中数据作用到页面中
        return View::make()->with(compact('data','attachment'));
    }

    public function remove(){
        //1、组合删除数据的sql
        //2、需要通过执行sql语句来完成删除信息
        $sql = "DELETE FROM student WHERE sid={$_GET['sid']}";
        //echo $sql;
        //1、执行无结果集e方法
        //2、有了sql语句还需要通过e方法来执行sql语句
        studentModel::e($sql);

        //1、获得数据库数据
        //2、我们需要判断数据库中数据是否为空
        $data = studentModel::get();
        if($data==[]){
            //1、将数据表中的主键初始化
            //2、如果数数据表中没有了数据，那么将主键初始化，下次添加时就会从1开始
            studentModel::e("TRUNCATE student");
        }

        //1、跳转到信息提示页面
        //2、删除成功之后会停留在空白页面，通过跳转到提示信息页面来解决
        $this->setRedirect(u('admin/student/index'))->message('删除学生信息成功');
    }
}