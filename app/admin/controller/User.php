<?php
//1、指定命名空间
//2、命名空间一个最明确的目的就是解决重名问题，PHP中不允许两个函数或者类出现相同的名字，否则会产生一个致命的错误。这种情况下只要避免命名重复就可以解决，最常见的一种做法是约定一个前缀。
namespace app\admin\controller;
use houdunwang\core\Controller;
use houdunwang\view\View;
use system\model\User as userModel;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
class User extends Controller {
    public function login(){
        if(IS_POST){
            //1、检测用户名是否存在
            //2、只有用户名存在，我们才可以登录到后台
            //获得用户输入的用户名
            $username = $_POST['username'];
            //1、查询数据库中用户名与$username相同的数据
            //2、通过查询数据来进行比较之前我们是通过获得数据库中的数据，再来与用户提交的数据进行比较
            $data = userModel::where( "username='{$username}'" )->get();
            //p($data);
            //1、检测是否能够获得数据
            //2、如果数据没有那么就会执行if()括号中的代码
            if(!$data){
                //1、跳转到提示信息页面
                //2、提示用户名用户名错误，并跳回到登录页面
                $this->setRedirect(u('login'))->message('你不是管理员，不能登陆');
            }

            //1、检测用户密码是否正确
            //2、只有密码正确才能登录
            //获得用户输入的密码
            $password = $_POST['password'];
            //1、通过上面获得的数据进行比较
            //2、如果通过上面的判断说明数据已经获得到，并存入$data变量中，那么我们就可利用数据中的密码来和用户输入的密码进行比较，
            if($data[0]['password'] != md5($password.'student')){
                //1、跳转到信息提示页面
                //2、如果密码不相等，还是给用户返回一个信息，让用户知道哪里错了
                $this->setRedirect(u('login'))->message('密码输入有误，重新输入');
            }

            //1、将用户信息存入session中
            //2、如果通过了上面的检测说明用户信息填写正确，那么就可以登录，那么可以将信息存到session中，我们需要到session来判断用户是否登录
            $_SESSION['user']=[
                //1、存入uid
                //2、我们需要用到uid来搜索同学的信息
                'uid' => $data[0]['uid'],
                //1、将用户名存入session中
                //2、我们需要在登录成功之后显示用户名
                'username' => $username,
            ];


            //1、设置7天免登陆
            //2、我们如果设置了免登陆，以后的时间段内就不需要登录
            if(isset($_POST['autologin'])){
                //1、设置cookie信息
                //2、如果用户选择了免登陆，那么我们就将session_id存入cookie中
                setcookie(session_name(),session_id(),time()+3600*24*7,'/');
            }else{
                //1、清除session
                //2、如果用户没有选择免登陆，那么我们就将session信息设置为会话期间，这样用户关闭会话好之后就没有session信息了
                setcookie(session_name(),session_id(),0,'/');
            }

            //1、登录成功之后跳转到首页
            //2、如果用户信息都填写正确，即数据与数据库中的一致，那么就允许用户登陆
            $this->setRedirect(u('home/entry/index'))->message("登陆成功，欢迎{$username}回来");

        }
        //1、载入模板
        //2、登录需要登录页面，所以需要载入页面
        return View::make();
    }

    /**
     * 退出登录
     */
    public function logout(){
        //1、清除session存在本地文件
        //2、清除了本地的session，那么只有服务器的session是没有用的
        session_destroy();
        //1、删除cookie中的session_id
        //2、清除了本地的session文件，那么session_id已经没有用了，所以一同删除
        session_unset();
        //1、跳转到登陆页面，并提示用户退出成功
        //2、我们退出之后，需要跳转到登录页面，不然会停留在空白页面
        $this->setRedirect(u('login'))->message('退出成功！');
    }

    /**
     * 验证码
     */
    public function captcha() {
        header( 'Content-type: image/jpeg' );
        $phraseBuilder = new PhraseBuilder( v('captcha.captcha_len') );
        $builder       = new CaptchaBuilder( null, $phraseBuilder );
        $builder->build();
        //1、把验证码存入session中
        //2、我们需要进行验证码比对，存入session中，方便我们进行验证码验证
        $_SESSION['captcha'] = strtolower( $builder->getPhrase() );
        $builder->output();
    }

    public function checkCaptcha(){
        //1、获得用户输入的验证码
        //2、我们需要用到用户输入的验证码来和session中的验证码进行比较
        $captcha = $_POST['c'];

        //1、获得存在session中的验证码
        //2、我们需要用session中的验证码来和到用户输入的验证码进行比较
        $s_captcha = $_SESSION['captcha'];
        //echo $s_captcha;
        //1、进行验证码比对
        //2、只有验证码一致才能注册，如果不进项比对，怎么输入都可以注册，这样就没有什么意义了，设置验证码是为了防止机器大批量注册，向数据库中写入无意义的数据
        if ($captcha==$s_captcha){
            //1、如果两个地方的验证码相等，那么返回一个标识，这里输出1
            //2、这里输出的结果我们可以在ajax中接收到，这样我们就可以通过接收到的值进行后续的操作了
            echo 1;
            //1、阻止后面代码运行
            //2、如果验证码没有填写正确，那么就不需要再往下面运行了，所以通过exit阻止之后的代码运行
            exit;
        }else{
            //1、如果不相等输出0
            //2、同样我们在ajax部分就可以通过这个值来进行后续的操作了
            echo 0;
        }
    }

    public function updatePassword(){
        //1、检测用户是否登录
        //2、如果没有登录是不能修改密码的，我们需要用户登录才能修改密码
        if(!isset($_SESSION['user'])){
            $this->setRedirect(u('login'))->message('亲，您需要先登录才能修改密码');
        }

        //1、获得用户数据
        //2、需要获得当前登录的用户名的信息，用户修改密码的时候需要获取密码进行比对，通过用户数据可以获得用户密码
        $data = userModel::where("username='{$_SESSION['user']['username']}'")->get();
        //p($data);
        //1、获得用户输入的旧的密码
        //2、需要拿用户输入的密码与原来的密码进行比对，如果输入原来的密码通过，才允许用户修改密码
        $oldPassword = isset($_POST['password']) ? $_POST['password'] : '' ;
        //p($oldPwd);
        if(IS_POST) {
            /**
             * 检测两次密码是否一致
             */
            //1、获得第一次密码
            //2、需要与重复密码进行比较
            $pwd1 = $_POST['password1'];
            //1、获得第二次输入的密码
            //2、需要与第一次密码进行比较
            $pwd2 = $_POST['password2'];
            if($pwd1!=$pwd2){
                //1、调转到提示信息页面
                //2、如果两次密码不一致，提示用户密码不一致
                $this->setRedirect(u('updatePassword'))->message('两次密码不一致');
            }
            /**
             * 检测旧密码
             */
            if ($data[0]['password'] != md5($oldPassword . 'student')) {
                //1、密码不一致跳转到提示页面
                //2、如果输入旧的密码通过，才允许用户修改密码
                $this->setRedirect(u('updatePassword'))->message('旧密码输入错误');
            }

            /**
             * 新密码和旧密码比较
             */
            if(md5($pwd1.'student')==$data[0]['password']){
                //1、新密码和旧密码一样，提示用户密码不能一样
                //2、如果输入新密码和旧密码一样，那么就没有修改的必要，提示用户不能一样
                $this->setRedirect(u('updatePassword'))->message('新密码不能和原来的密码一样');
            }

            //1、组合sql语句
            //2、通过sql语句完成密码修改
            $sql = "UPDATE user SET password = md5('{$pwd1}student') WHERE username='{$data[0]['username']}'";
            //echo $sql;

            //1、执行sql语句
            //2、执行无结果集方法e()
            userModel::e($sql);
            //1、清除session存在本地文件
            //2、修改密码之后，需要重新的登录，所以需要先清除本地的session，那么只有服务器的session是没有用的
            session_destroy();
            //1、删除cookie中的session_id
            //2、清除了本地的session文件，那么session_id已经没有用了，所以一同删除
            session_unset();

            $this->setRedirect(u('login'))->message('密码修改成功，需要重新登陆');

        }

        //1、载入修改密码页面
        //2、修改密码需要先载入页面，需要通过输入框来填写信息
        return View::make()->with(compact('data'));
    }
}