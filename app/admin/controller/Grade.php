<?php
//1、指定命名空间
//2、命名空间一个最明确的目的就是解决重名问题，PHP中不允许两个函数或者类出现相同的名字，否则会产生一个致命的错误。这种情况下只要避免命名重复就可以解决，最常见的一种做法是约定一个前缀。
namespace app\admin\controller;
use houdunwang\view\View;
use system\model\Grade as gradeModel;


class Grade extends Com {
    public function index(){
        //1、获得班级信息
        //2、我们需要在页面显示班级数据信息，
        $data = gradeModel::get();
        //1、载入页面，传入参数
        //2、显示班级信息需要通过页面显示
        return View::make()->with(compact('data'));
    }

    public function store(){
        //1、判断是否为post提交
        ///2、添加班级。即向数据库中添加数据是post提交之后的才执行的代码
        if(IS_POST){
            //1、获得班级数据
            //2、我们需要判断班级是否已存在，如果存在就提示用户班级已经存在
            $data = gradeModel::get();
            //p($data);
            foreach ($data as $g){
                //1、判断班级是否存在
                //1、如果添加的班级已经存在，那么就提示用户班级已经添加，否则会向数据库中添加相同班级名的数据
                if($g['gname']==$_POST['gname']){
                    //1、跳转到提示页面之后回到添加班级页面
                    //2、如果班级已经存在，那么先提示用户之后跳回添加页面让用户重新添加，用户体验更好
                    $this->setRedirect(u('store'))->message('该班级已经添加过了');
                }
                //1、判断用户是否输入内容
                //2、如果用户没有输入内容，那么就提示用户班级名不能为空，跳转到添加页面，让用户重新添加
                if($_POST['gname']=='') $this->setRedirect(u('store'))->message('班级名不能为空');
            }
            //1、组合sql语句
            //2、添加数据需要组合添加数据的sql语句，这里获得用户输入的班级名$_POST['gname']
            $sql = "INSERT INTO grade SET gname='{$_POST['gname']}'";
            //echo $sql;
            //1、执行无结果集sql
            //2、有了sql语句，我们还需要执行才能向数据库中添加数据
            gradeModel::e($sql);
            //1、跳转信息提示页面
            //2、添加成功之后，我们需要给用户有个提示信息，并跳转到班级列表页面
            $this->setRedirect(u('index'))->message('添加成功');
        }
        //1、载入添加班级模板
        //2、我们需要将数据中的信息（班级名）显示到班级列表页面中
        return View::make();
    }

    //1、编辑班级
    //2、用来管理编辑页面的操作
    public function update(){
        //1、获得班级数据
        //2、我们需要判断班级是否已存在，如果存在就提示用户班级已经存在
        $data = gradeModel::get();
        //1、获得旧数据
        //2、我们编辑是在原来的数据上进行编辑的
        $oldData = gradeModel::findArray($_GET['gid']);
        //p($oldData);
        if (IS_POST){
            //1、组合sql语句
            //2、我们修改数据需要通过sql语句来修改数据，所以要组合好一条修改数据的sql语句
            $sql = "UPDATE grade SET gname='{$_POST['gname']}' WHERE gid='{$_GET['gid']}'";

            foreach ($data as $g){
                //1、判断班级是否存在
                //1、如果添加的班级已经存在，那么就提示用户班级已经添加，否则会向数据库中添加相同班级名的数据
                if($g['gname']==$_POST['gname']){
                    //1、跳转到提示页面之后回编辑页面
                    //2、如果修改时班级已经存在，那么先提示用户之后跳回修改页面让用户重新修改，用户体验更好
                    $this->setRedirect(u('update')."&gid={$_GET['gid']}")->message('该班级已存在');
                }

            }
            //echo $sql;
            //1、执行无结果集sql
            //2、有了sql语句，还需要通过无结果集方法来完成数据的修改
            gradeModel::e($sql);
            //1、跳转到班级列表页面
            //2、修改成功之后，需要给用户提示修改成功，然后跳回列表页面
            $this->setRedirect(u('index'))->message('修改成功');
        }

        //1、载入页面，同时显示所要编辑的数据
        //2、编辑操作需要通过页面才能操作，需要在原来的数据上修改
        return View::make()->with(compact('oldData'));
    }

    //1、删除班级
    public function remove(){
        //1、获得所要删除的班级的编号
        //2、我们执行删除sql语句的时候，需要用到班级编号作为条件来进行对应的删除操作
        $gid = intval($_GET['gid']);

        //1、先判断班级是否有学生
        //2、如果该班级有学生，那么需要先删除学生信息
        if(\system\model\Student::where("gid={$gid}")->get()){
            $this->setRedirect(u('index'))->message('请先删除该班级里面的学生信息');
        }
        //echo $gid;
        //1、组合sql语句
        //2、我们选用通过执行sql语句来完成删除操作
        $sql = "DELETE FROM grade WHERE gid={$gid}";
        //echo $sql;
        //1、执行删除操作
        //2、有了删除数据的sql语句，还需要通过无结果集方法完成数据的删除
        gradeModel::e($sql);
        //1、跳转到班级列表页面
        //2、删除成功之后，需要给用户提示修删除成功，然后跳回列表页面
        $this->setRedirect(u('index'))->message('删除成功');
    }

}