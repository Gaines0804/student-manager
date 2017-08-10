<?php
//1、定义一个命名空间
//2、命名空间一个最明确的目的就是解决重名问题，PHP中不允许两个函数或者类出现相同的名字，否则会产生一个致命的错误，有了命名空间，就能PHP中解决函数、方法冲突的情况
namespace houdunwang\view;
//1、定义一个Base类
//2、主要是用来实现app应用中的页面和数据的载入和传输
class Base{
    //1、定义一个属性
    //2、用来存放make方法中组合的路径，我们需要在下面的很多方法中用到
    private $path;
    //1、定义一个空数组属性
    //2、用来存放with方法接收过来的数据，我们需要在__toString中使用
    private $var=[];
    //1、定义一个make方法
    //2、用来完成模版的载入
    public function make(){
        //$path = "../app/home/view/entry/index.php";
        //1、组合路径，存放到私有属性中
        //2、我们已经在Boot核心类中将模块、控制器、方法名定义为常量了，在这里可以随意使用，完成组合路径
        $this->path = "../app/".MODULE.'/view/'.CONTROLLER.'/'.ACTION.'.php';
        //p($this->path);
        //include $this->path;
        //1、返回当前对象
        //2、我们在Entry方法中需要通过实例化对象的方法来调用，所以需要返回一个对象。例如：View::make()->with($data);
        return $this;
    }
    //1、定义一个with方法
    //2、通过with方法来接收数据
    public function with($data){
        //1、接收数据，存入属性中
        //2、我们需要在__toString方法中使用，如果不存入属性中，那么只能在当前方法使用
        $this->var=$data;
        //p($this->var);
        //1、返回当前对象
        //2、我们在Entry方法中需要通过实例化对象的方法来调用，所以需要返回一个对象。例如：View::with($data)->make();
        return $this;
    }

    //1、调用__toString函数
    //2、将上面的make方法中组合的路径和with方法中获得的数据，归总到这里，在Entry方法中不管make和with的顺序如何，都能完成模板载入和数据传输，因为该方法只有当我们打印输出对象的时候才会执行
    public function __toString(){
        //1、extract函数使用数组键名作为变量名，使用数组键值作为变量值。针对数组中的每个元素，将在当前符号表中创建对应的一个变量。
        //2、将之前compact组合的数组，再次分为变量赋值的形式，我们可以结合下面载入的页面，在页面中使用extract返回的变量，使用变量
        extract($this->var);
        //1、执行include导入模板
        //2、通过include导入属性中存储的路径，完成载入模板
        include $this->path;
        //1、返回一个空字符串
        //2、因为执行__toString方法最终必须返回一个字符串，这里不需要有任何值，所以给定一个空字符串
        return '';
    }
}