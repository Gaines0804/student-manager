<?php
//1、指定命名空间
//2、命名空间一个最明确的目的就是解决重名问题，PHP中不允许两个函数或者类出现相同的名字，否则会产生一个致命的错误。这种情况下只要避免命名重复就可以解决，最常见的一种做法是约定一个前缀。
namespace app\admin\controller;
use Exception as MazhenyuException;
use houdunwang\core\Controller;
use system\model\Attachment;

//1、定义一个公共类
//2、用来判断用户是否登陆，如果我们每次判断都要写检测session是否存在很麻烦，通过一个公共类就能实现
class Com extends Controller {
    //1、定义构造方法
    //2、当我们一调用Com类的时候就执行检测
    public function __construct(){
        $this->checkLogin();
    }

    /**
     * 检测用户是否登录
     * 通过session是否存，来检测是否已有用户登陆
     */
    public function checkLogin(){
        if(!isset($_SESSION['user'])){
            //1、检测跳转、提示信息
            //2、如果session里面的用户信息不存在，那么就提示用户需要登录，
            $this->setRedirect(u('admin/user/login'))->message('亲，您需要先登录才能操作哦');
        }
    }


    protected function upload() {
        //上传目录
        $dir = './attachment/' . date( 'ymd' );
        is_dir( $dir ) || mkdir( $dir, 0755, true );
        $storage = new \Upload\Storage\FileSystem( $dir );

        $file    = new \Upload\File( 'profileupload', $storage ); 

// Optionally you can rename the file on upload
        $new_filename = uniqid();
        $file->setName( $new_filename );

// Validate file upload
// MimeType List => http://www.iana.org/assignments/media-types/media-types.xhtml
        $file->addValidations( array(
            // Ensure file is of type "image/png"
//          new \Upload\Validation\Mimetype( 'image/png'),

            //You can also add multi mimetype validation
            new \Upload\Validation\Mimetype( array( 'image/png', 'image/gif', 'image/jpeg' ) ),

            // Ensure file is no larger than 5M (use "B", "K", M", or "G")
            new \Upload\Validation\Size( '2M' )
        ) );

// Access data about the file that has been uploaded
        $data = array(
            'name'       => $file->getNameWithExtension(),
            'extension'  => $file->getExtension(),
            'mime'       => $file->getMimetype(),
            'size'       => $file->getSize(),
            'md5'        => $file->getMd5(),
            'dimensions' => $file->getDimensions()
        );


// Try to upload file
        try {
            // Success!
            //1、调用方法执行上传
            //2、需要调用上传文件的方法，才能实现上传
            $file->upload();

            //以下几行代码自己处理
            //完整文件名
            $fullPath = $dir . '/' . $data['name'];
            //将附件路径存入附件表中
            Attachment::e("INSERT INTO attachment SET path='{$fullPath}',createtime=" . time());
            //返回文件名
            return $fullPath;
        } catch ( MazhenyuException $e ) {
            // Fail!
            throw new MazhenyuException( $file->getErrors()[0] );
        }
    }
}