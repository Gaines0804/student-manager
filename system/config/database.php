<?php
//1、使用setConfig方法所在命名空间下的类
//2、我们使用setConfig方法时候，在当前文件并不存在，而是存在Model类里面，我们使用的时候，需要到指定的命名空间下米去调用
use \houdunwang\model\Model;
//1、定义一个配置项数组
//2、我们在连接数据库的时候需要用到这些匹配内容，将来我们的项目上线之后，这些配置不一定是我们现在规定的，所以将数据库的信息作为配置项加载，适应的时候，只需要修改配置项，而不需要修改模型里面的方法，就能完成数据库的配置
$config = [
    'db_host' => '127.0.0.1',
    'db_user' => 'root',
    'db_password' => 'root',
    'db_name' => 'students',
    'db_charset' => 'utf8'
];
//1、静态调用setConfig方法，将配置项中的数据作为参数传入
//2、传入数据，因为我们连接数据库的时候需要用到这些信息
Model::setConfig($config);