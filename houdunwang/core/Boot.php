<?php
//1、定义一个命名空间
//2、命名空间一个最明确的目的就是解决重名问题，PHP中不允许两个函数或者类出现相同的名字，否则会产生一个致命的错误，有了命名空间，就能PHP中解决函数、方法冲突的情况
namespace houdunwang\core;

class Boot{

    public static function run(){
        self::handelError();
        //1、静态调用init方法
        //2、通过内部静态调用init方法，来完成框架的初始化，以后只要我们一执行run方法就会调用init方法来初始化框架
        self::init();
        //1、内部静态调用appRun方法
        //2、appRun方法其实是我们最核心的方法，我们就是通过该方法来完成app应用类的载入、功能的实现的，可以说是通往框架内部的入口
        self::appRun();
    }
    static private function handelError() {
        $whoops = new \Whoops\Run;
        $whoops->pushHandler( new \Whoops\Handler\PrettyPageHandler );
        $whoops->register();
    }

    //1、初始化框架
    //2、
    public static function init(){

        //1、开启session
        //2、我们需要在用户注册登录模块时用到session来检测用户是否登录，使用session时，需要先开启session，这里通过session_id来检测，如果存session_id，说明session已经开启，如果不存在那么就开启
        session_id() || session_start();
        //1、设置时区
        //2、我们中国所在时区属于东八区，将时区设置为东八区，比如我们可能会在用户注册时候用到时间，设置为东八区之后，我们在中国的时间就是正确的，如果不设置，那么可能会相差几个小时
        date_default_timezone_set("PRC");

        //1、定义IS_POST常量
        //2、在很多场景都会用到IS_POST来检测是否为POST提交，例如：检测用户是否点击了登录按钮：if(IS_POST){} 如果点击了按钮，那么就执行{}里面对的内容
        define("IS_POST",$_SERVER["REQUEST_METHOD"] == "POST" ? true : false);

        //p($_SERVER);
        define("__ROOT__","http://".$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']);
        //p(__ROOT__);
    }

    //1、定义静态appRun方法
    //2、appRun方法其实是我们最核心的方法，我们就是通过该方法来完成app应用类的载入、功能的实现的，可以说是通往框架内部的入口
    public static function appRun(){
        //?s=home/entry/index通过这样的路径来访问app里面的模板页面
        //1、判断是否存在地址参数
        //2、我们很多时候都是通过地址栏的参数来载入页面的，如果用户在地址栏中传入参数，那么就可以访问相应的页面
        if(isset($_GET['s'])){
            //1、获得参数，并转换为数组
            //2、我们需要分别获得参数中的模块名、控制器名、方法名来组合路径，载入相应的模板
            $info = explode('/',$_GET['s']);
            //p($info);
            //Array
            //(
            //    [0] => home
            //    [1] => entry
            //    [2] => add
            //)

            //include "./app/home/view/entry/index.php"

            //1、获得模块名
            //2、需要用到模块名来组合路径，例如上述例子中的home
            $m = $info[0];
            //1、获得控制器名
            //2、获得需要用到模块名来组合路径，例如上述例子中的entry
            $c = $info[1];
            //1、方法名
            //2、需要用到模块名来组合路径，例如上述例子中的index
            $a = $info[2];
        }else{
            //1、指定默认的模块名
            //2、需要用到模块名来组合路径，例如上述例子中的home
            $m = 'home';
            //1、指定默认的控制器
            //2、需要用到模块名来组合路径，例如上述例子中的entry
            $c = 'entry';
            //1、指定默认的方法名
            //2、需要用到模块名来组合路径，例如上述例子中的index
            $a = 'index';
        }

        //1、定义常量MODULE
        //2、我们需要在Base类中组合路径，实现模板的载入
        define('MODULE',strtolower($m));
        //1、定义常量CONTROLLER
        //2、我们需要在Base类中组合路径，实现模板的载入
        define('CONTROLLER',strtolower($c));
        //1、定义常量ACTION
        //2、我们需要在Base类中组合路径，实现模板的载入
        define('ACTION',strtolower($a));


//        $obj = new \app\home\controller\Entry();
//        $obj ->index();
        //1、将$c首字母大写
        //2、因为实例化类的时候，控制器名首字母为大写
        $controller = ucfirst($c);
        //1、组合对象
        //2、我们需要实例化对象，调用对应的方法，例如上面的$obj对象
        $class = "\app\\".$m."\controller\\".$controller;
        //1、通过函数实现实例化和调用
        //2、我们白不用上面的方法，是因为，有的时候我们需要传入参数，如果传入多个参数，那么就不好处理，通过这个函数，不管传入多少个参数，最终都组合成为一个数组，这样方便我们操作
        //3、这里使用echo输出对象，会报错，但是我们在Base类中，已经使用了__toString函数，当我们输出对象的时候就会自动执行__toString方法（函数），此时就不会报错
        echo call_user_func_array([new $class,$a],[]);
    }

}