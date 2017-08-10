<?php
/**
 * Created by PhpStorm.
 * User: Adminstrator
 * Date: 2017/7/2
 * Time: 17:58
 */
//1、指定命名空间
//2、命名空间一个最明确的目的就是解决重名问题，PHP中不允许两个函数或者类出现相同的名字，否则会产生一个致命的错误。这种情况下只要避免命名重复就可以解决，最常见的一种做法是约定一个前缀。
namespace system\model;


use houdunwang\model\Model;

class Attachment extends Model {

}