<?php
namespace app\home\controller;

use app\admin\controller\Com;
use houdunwang\view\View;
use system\model\Student;

class Entry extends Com {
    public function index(){
        //1、获得数据库中的学生信息
        //2、我们需要在页面县学生所有信息
        $stuData = Student::q("SELECT * FROM student as s JOIN grade as g ON s.gid=g.gid");
        //p($stuData);

        //1、载入页面
        //2、我们需要通过页面显示信息
        return View::make()->with(compact('stuData'));
    }

    /**
     * 显示学生信息
     */
    public function show(){
        //1、获得编辑时传递过来的sid
        //2、我们需啊哟通过sid来查询获得对应的小学生信息
        $sid = intval($_GET['sid']);
        //1、执行sql语句获得对应sid的学生信息
        //2、我们需要在页面显示学生的所有信息，包括班级，这里需要关联查询
        $stuData = Student::q("SELECT * FROM student as s JOIN grade as g ON s.gid=g.gid WHERE sid={$sid}");
        //p($stuData);exit;

        //1、载入页面，并将获得的数据传递过去
        //2、我们需要通过页面显示信息，现显示的信息是通过数据获得的
        return View::make()->with(compact('stuData'));
    }
}