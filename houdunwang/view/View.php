<?php
//1、定义一个命名空间
//2、命名空间一个最明确的目的就是解决重名问题，PHP中不允许两个函数或者类出现相同的名字，否则会产生一个致命的错误，有了命名空间，就能PHP中解决函数、方法冲突的情况
namespace houdunwang\view;
class View{
    public function __call($name, $arguments){
        return call_user_func_array([new Base(),$name],$arguments);
    }

    public static function __callStatic($name, $arguments){
        return call_user_func_array([new Base(),$name],$arguments);
    }
}