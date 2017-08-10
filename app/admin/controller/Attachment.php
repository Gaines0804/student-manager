<?php
//1、指定命名空间
//2、命名空间一个最明确的目的就是解决重名问题，PHP中不允许两个函数或者类出现相同的名字，否则会产生一个致命的错误。这种情况下只要避免命名重复就可以解决，最常见的一种做法是约定一个前缀。
namespace app\admin\controller;
//1、使用attachment所在命名空间下面的类，并给定别名attachmentModel
//2、这样我们就能通过attachmentModel::get来获得数据
use system\model\Attachment as atModel;
//1、使用命名空间下面的View类
//2、这样我们就能使用View类中的make()和with方法
use houdunwang\view\View;


class Attachment extends Com {
     public function index(){
         //1、获得附件表中的数据
         //2、我们需要在页面中显示图片，重复的数据就不显示了
         $data = atModel::get();

         //p($data);exit;
         //1、载入模板，传递数据
         //2、我们要显示学生信息需要页面，需要在页面中显示数据，通过传递数据我们可以显示信息
         return View::make()->with(compact('data'));
     }

     public function remove(){

         //1、获得对应附件的aid
         //2、我们需要删除对应的附件，所以需要通过aid获得附件路径
         $aid = intval($_GET['aid']);

         //echo $aid;exit;
         //1、获得对应附件的路径
         //2、我们需要删除对应的附件，这里通过get参数获得路径
         $path = $_GET['path'];
         //echo $path;exit;
         //1、删除附件
         //2、我们点击了删除之后需要将目录下面的福阿金删除
         is_file($path) && unlink($path);

         //1、删除对应aid的数据库信息
         //2、我们点击删除的时候需要将数据库中的数据删除
         $sql = "DELETE FROM attachment WHERE aid={$aid}";
         //执行删除sql语句
         atModel::e($sql);

         //1、获得数据库数据
         //2、我们需要判断数据库中数据是否为空
         $data = atModel::get();
         if($data==[]){
             //1、将数据表中的主键初始化
             //2、如果数数据表中没有了数据，那么将主键初始化，下次添加时就会从1开始
             atModel::e("TRUNCATE attachment");
         }

         //1、跳转到信息提示页面
         //2、删除成功之后跳回列表页面，否则就会停留在空白页面
         $this->setRedirect(u('attachment/index'))->message('附件删除成功');
     }
}