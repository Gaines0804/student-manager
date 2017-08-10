<?php
namespace houdunwang\model;
use PDO;
use PDOException;
class Base{
    //1、定义一个静态属性
    //2、用来存放数据库对象，我们为了只需要连接一次数据库，不需要多次连接，当我们把数据库对象存入静态属性中，下次执行connect方法时，只需要判断数据库对象是否存在，如果存在那么就不需要再次连接
    private static $pdo;

    //1、定义一个属性
    //2、用来存放实例化Base时候的参数$table;
    private $table;
    //1、定义一个属性
    //2、用来存放
    private $where;

    //1、调用一个构造方法
    //2、我们显示文章数据，需要连接数据库，我们通过构造方法调用连接方法
    public function __construct($config,$table){
        //1、调用connect方法连接数据
        //2、我们实例化Base类的时候，就会执行构造方法，我们在这里调用，就会第一时间连接数据库
        $this->connect($config);
        //p($config);
        //1、实例化时候掺入的表名存入属性中
        //2、我们需要在下面的q方法和get方法中使用表名来进行数据的查询
        $this->table = $table;
    }

    //1、定义一个连接数据库的方法
    //2、我们很多场景都需要用到数据库连接，比如文章查看、显示、添加等，我们为了不需要每次都连接数据库
    public function connect($config){
        //1、判断数据库是否连接
        //2、我们为了只需要连接一次数据库，不需要多次连接，当我们把数据库对象存入静态属性中，下次执行connect方法时，只需要判断数据库对象是否存在，如果存在那么就不需要再次连接
        if(!is_null(self::$pdo)) return;
        try{
            //p($config);
//        Array
//        (
//            [db_host] => 127.0.0.1
//            [db_user] => root
//            [db_password] => root
//            [db_name] => c81
//            [db_charset] => utf8
//        )
            //1、拼接数据库类型和主机
            //2、我们通过实例化PDO连接数据库的时候需要使用到主机名
            $dsn = "mysql:host=" . $config['db_host'] . ";dbname=" . $config['db_name'];
            //p($dsn);   // mysql:host=127.0.0.1;dbname=c81
            //1、获得用户名
            //2、我们通过实例化PDO连接数据库的时候需要使用到用户名
            $user = $config['db_user'];
            //p($user);
            //1、获得数据库密码
            //2、我们通过实例化PDO连接数据库的时候需要使用密码
            $password = $config['db_password'];
            //p($password);
            //1、连接数据库
            //2、我们之后的文章添加、删除修改等操作都需要使用数据库，所以需要连接数据库
            $pdo = new PDO($dsn,$user,$password);

            //1、设置错误类型
            //2、将错误类型设置为异常错误，那么不管之后的数据查询、修改、删除的操作出现错，我们都能都获得到，这样对我们排错有帮助
            $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

            //1、设置字符集类型
            //2、设置字符集编码，保证我们的框架不管在哪里连接数据库，里面的数据都能正常显示
            $pdo->query("SET NAMES ".$config['db_charset']);

            //1、将对象存入静态属性中
            //2、我们需要该对象是否存在判断是否连接数据库，同时需要在q方法中使用来查询数据
            self::$pdo = $pdo;
            //echo 'success';
        }catch (PDOException $e){
            exit($e->getMessage());
        }
    }
    //1、定义一个where方法
    //2、用来组合where条件，我们在查询数据的时候有时候会指定条件
    public function where($where){
        $this->where = " WHERE ".$where;
        //p($this->where);exit;
        //1、返回当前对象
        //2、我们在外部链式调用的时候需要实例化当前类，所以要返回当前类
        return $this;
    }
    //1、定义一个get方法
    //2、通过外部静态调用此方法来获得数据表中的数据
    public function get(){
        //1、书写sql查询语句
        //2、我们需要通过执行sql语句来完成数据的查询
        $sql = "SELECT * FROM {$this->table} {$this->where}";
        //echo $sql;  SELECT * FROM article WHERE aid=3
        //1、返回数据
        //2、将数据返回给Entry里面的arc方法，谁调用get方法就将数据返回给谁
        return $this->q($sql); //调用q方法将数据传入，在q方法中执行语句
    }

    //1、定义一个find方法
    //2、通过find方法快速查找对应aid的数据
    public function find($pri){
        //1、将getPri方法返回的主键名存入变量
        //2、我们需要在where条件中利用主键名，进行数据的筛选查询，这里获得的主键名是aid
        $field =  $this->getPri();
        //1、调用where方法
        //2、调用方法组合条件：这里组合完成之后为：WHERE aid=2
        $this->where("{$field}={$pri}");
        //1、组合sql语句
        //2、通过表名和条件组合出sql语句，我们之后利用q函数就能执行sql语句得到所要筛选的数据
        $sql = "SELECT * FROM {$this->table} {$this->where}";
        //p($sql);  //SELECT * FROM article  WHERE aid=2
        //1、执行sql语句
        //2、有了sql语句，我们还需要执行，这里通过q方法执行有结果集的sql语句，这里得到aid=2的数据
        $data = $this->q($sql);
        //p($data);
        //1、将二维数组转换为一维数组
        //2、我们只需要得到有效的数据，这里只需要得到aid和title，当给用户显示的时候，不需要二维数组，一维数组已经足够了
        $data = current($data);
        //p($data);
        //1、将数据存入属性中
        //2、
        $this->data = $data;
        //p($this);
        //1、返回当前对象
        //2、为了之后我们需要链式调用，例如Model::find(2)->toArray();
        return $this;
    }
    //1、定义一个toArray方法
    //2、其实我们在find方法中已经得到了我们想要的数据，但是为提高可读性，即我们希望通过Model::find(4)->toArray()这样的方式来获得数据，所以还需要定义一个方法
    public function toArray(){
        return $this->data;
    }

    //1、定义一个findArray方法
    //2、其实等价于find(2)->toArray()，但为了用户能够更好的选择，我们还需要一些获得数据的方式
    public function findArray($pri){
        //1、调用find方法
        //2、获得一个当前对象，因为对象中包含有数据，我们需要获得对象中的数据
        $obj = $this->find($pri);
        //p($obj);
        //1、获得对象中的数据
        //2、我们只需要用到对象中的有效的数据部分，例如：aid和title
        return $obj->data;
    }

    //1、定义一个获得数据表的主键名的方法
    //2、需要在find方法中使用到，我们不知道数据表的主键名是什么，所以需要这个方法来获得
    public function getPri(){
        //1、执行q方法，获得数据表的结构
        //2、我们需要从结构中获得主键名
        $desc = $this->q("DESC $this->table");
        //p($desc);exit;
        //1、循环表结构，
        //2、循环得到的结果包含带有主键的字段，这里我们需要获得带有主键的字段名，这里的主键为aid
        foreach ($desc as $v){
            //1、判断是否为主键
            //2、通过表结构数组中查看是否存在主键，如果存在主键，那么就获得主键名，我们在find方法中需要用到主键名来作为条件查询数据
            if($v['Key']=='PRI'){
                //1、返回主键名
                //2、我们需要在find方法中，将主键名作为删选条件来进行数据筛选数据
                return $v['Field'];
            }
        }
    }

    //1、定义一个统计数据的方法
    //2、我们很多场景都会有统计一个数据表中数据总数的需求
    public function count(){
        $sql = "SELECT COUNT(*) as c FROM {$this->table} {$this->where}";
        //echo $sql;   //SELECT COUNT(*) as c FROM article
        //1、执行q方法
        //2、有了sql语句还需要通过q方法、来返回一个结果集
        $res = $this->q($sql);
        //p($res);
//        Array
//        (
//            [0] => Array
//            (
//                [c] => 4
//            )
//        )
        //1、获得有效结果
        //2、我们统计数据，很多情况只需要得到一个数据结果，这里只需要得到 4 即可，通过数组索引最终得到结果：4
        return $res[0]['c'];
    }

    //1、定义一个q方法
    //2、主要用来执行有结果集sql语句，之后我们有场景用到结果集的地方，只需要调用该方法，就能等到结果
    public function q($sql){
        try{
            //1、执行结果集sql语句
            //2、我们有了sql语句，还需要通过query函数来执行，获得结果集
            $res = self::$pdo->query($sql);
            //p($sql);
            //1、将结果集对象通过fetch函数之后转换为可操作的数组
            //2、转为数组之后我们就可以对数组进行操作了
            $data = $res->fetchAll(PDO::FETCH_ASSOC);
            //p($data);
            //1、将数据返回给get方法
            //2、我们需要通过get方法来获得数据，所以需要先将数据返回给get方法
            return $data;
        }catch (PDOException $e){
            //1、获得异常错误，并结束代码运行
            //2、如果存在异常错误，那么我们就显示异常错误，后面的代码就没有必要执行了，所以利用exit终止代码
            exit($e->getMessage());
        }
    }


    /************************执行无结果集的操作 *************************/
    //1、定义一个执行无结果集sql语句的方法
    //2、我们操作数据库的时候，会有两种结果：有结果集、无结果集，有结果集的我们上面用了q（query首字母）方法，这里我们使用e（execute首字母）方法执行无结果集sql语句
    public function e($sql){
        try{
            //1、执行execute方法
            //2、我们对数据进行添加、删除、修改时，不需要返回结果，所以这里执行exec方法，返回受影响的数据的条数，这里返回 1
            $res = self::$pdo->exec($sql);
            //1、返回结果
            //2、这里返回受影响的数据条数，无结果集只会返回受影响的数据的条数
            return $res;
        }catch (PDOException $e){
            //1、获得异常错误，并结束代码运行
            //2、如果存在异常错误，那么我们就显示异常错误，后面的代码就没有必要执行了，所以利用exit终止代码
            exit($e->getMessage());
        }
    }
}