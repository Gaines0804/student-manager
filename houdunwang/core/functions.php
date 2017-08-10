<?php
function p($var){
    echo "<pre style='font-size: 20px'>".print_r($var,true)."</pre>";
}


function u($url){
    //p($url);
    //1、获得的参数转换为数组
    //2、我们需要通过统计数组中的参数个数，来拼接不同的地址路径，如果以后我们进行页面跳转等操作时，只需要简单传入参数就能完成跳转
    $arr = explode('/',$url);
    //p($arr);
    //1、定义一个字符串变量
    //2、用来存放组合之后的路径，例如：?s=home/entry/index
    $path = '';
    switch (count($arr)){
        case 1:
            $path = "?s=".MODULE.'/'.CONTROLLER.'/'.$arr[0];   //?s=home/entry/index
            break;
        case 2:
            $path = "?s=".MODULE.'/'.$arr[0].'/'.$arr[1];   //?s=home/arc/lists
            break;
        case 3:
            $path = "?s=".$arr[0].'/'.$arr[1].'/'.$arr[2];
    }
    return __ROOT__.$path;

    //p( __ROOT__.$path);
//    u('home/entry/index'):http://localhost/houdun/frame/0628/public/index.php?s=home/entry/index
//    u('add'):http://localhost/houdun/frame/0628/public/index.php?s=home/entry/add
//    u('arc/lists'):http://localhost/houdun/frame/0628/public/index.php?s=home/arc/lists
}