<?php
namespace houdunwang\core;
class Controller{
    private $url='window.history.back()';
    //1、定义一个受保护的方法
    //2、用来指定跳转页面路径
    protected function setRedirect($url=''){

        //p($url);
        //var_dump($url);
        //1、判断$url是否存在
        //2、如果不存在，就相当于没有传任何参数，那么我们就默认返回上一个历史记录
        if(empty($url)){
            $this->url="window.history.back()";
        }else{
            //1、指定跳转页面
            //2、如果传入了参数，那么就跳转到指定的页面，例如：传入参数‘index’
            //http://localhost/houdun/frame/0628/public/index.php?s=home/entry/index
            $this->url = "location.href='{$url}'";

            //echo 123;
        }
        return $this;
    }
    public function message($msg){
        include './view/message.php';
        exit;
    }
}
