<?php
function dd($var){
    echo "<pre>" . print_r($var,true) . "</pre>";
}

//1、定义一个v函数
//2、我们在调用验证方法的时候需要设置验证码的长度，而我们又将验证码的长度存入配置文件中，我们需要通过一个函数来获得配置文件中的数据
function v($var){
    $arr = explode('.',$var);
    //$arr = ['captcha','captcha_len'];
    //1、载入配置文件中的数组
    //2、只有获得配置文件中的数据，我们才能获得验证码的长度
    $config = include "../system/config/{$arr[0]}.php"; //此时的路径为"../system/config/captcha.php"
    //1、返回验证码的长度
    //2、检测配置项中的验证长度是否存在，如果不存在就给默认值为空
    return isset($config[$arr[1]]) ? $config[$arr[1]] : 4;
}