<?php
//数据库
//create database student charset utf8;

//班级表
//create table grade(
//    gid smallint unsigned primary key auto_increment,
//    gname char(20) not null default ''
//);

//学生表
//create table student(
//    sid smallint unsigned primary key auto_increment,
//    sname char(20) not null default '' comment '学生姓名',
//    profile varchar(255) not null default '' comment '学生头像',
//    sex enum('男','女') not null default '男' comment '性别',
//    birthday date comment '出生日期',
//    introduction varchar(255) not null default '' comment '个人简介',
//    gid smallint unsigned not null default 0 comment '班级ID'
//);

//用户表
//create table user(
//    uid smallint unsigned primary key auto_increment,
//    username char(20) not null default '' comment '用户名',
//    password char(32) not null default '' comment '密码'
//);

//附件表
//create table attachment(
//    aid int unsigned primary key auto_increment,
//    path varchar(255) not null default '' comment '附件路径',
//    createtime int unsigned not null default 0 comment '附件创建时间'
//);
