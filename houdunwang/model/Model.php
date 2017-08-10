<?php
namespace houdunwang\model;
class Model{
    //1、定义一个静态属性
    //2、用来存放下面方法setConfig方法获得的配置项数据，我们需要将数据传入到Base类中的__construct构造方法中
    private static $config;

    public function __call($name, $arguments){
        return self::parseAction($name, $arguments);
    }
    public static function __callStatic($name, $arguments){
        return self::parseAction($name, $arguments);
    }
    public static function parseAction($name, $arguments){
        //1、获得调用当前的那个类名（包含命名空间） 这里是：system\model\Article
        //2、我们获得这个类是为了得到表名article，我们需要在q方法执行get里面的sql语句的时候用到表名，也就是为什么我们需要类名和表名一样，这样的话，我们只需要对类名进行一些截取操作就能获得表名
        $class = get_called_class();
        //echo $class;  //system\model\Article
        $table = strtolower(ltrim(strrchr($class,'\\'),'\\'));
        //p($table);  //执行截取字符串时候得到\Article,执行ltrim得到结果：Article,再执行strtolower函数得到表名：article
        //1、实例化类调用里面的方法
        //2、这里实例化Base类，同时将参数self::$config(已存入静态属性中了，我们需要在连接数据库的时候使用)、$table(我们需要在sql语句中使用)一同传入
        return call_user_func_array([new Base(self::$config,$table),$name],$arguments);
    }
    //1、定义一个获得配置项内容的静态方法
    //2、用来设置数据库配置信息，我们需要在连接数据库的时候使用配置信息
    public static function setConfig($config){
        //1、将数据存入静态属性中
        //2、我们需要在上面的自动加载加载方法中实例化Base类连接数据库，而连接数据库的时候需要用到配置信息，我们需要将数据传给Base类，但是数据信息存在当前方法，不能被其他方法使用，所以需要存到属性中
        self::$config = $config;
    }
}