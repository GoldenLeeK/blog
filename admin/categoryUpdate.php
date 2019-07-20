<?php
/**
 * Created by PhpStorm.
 * User: 61458
 * Date: 2019/7/6
 * Time: 12:52
 * 更新博客分类
 */

namespace lib;
session_start();
require_once '../autoload.php';
//接收前端发过来的数据
$id = (int)$_POST['id'];
$data['cate_name']  =  $_POST['name'];
//插入数据库
$db = Db::getInstance();
if ($db->table('cates')->where("id=$id")->update($data)){
    exit(json_encode(['code' => 1, 'msg' => '恭喜你，更新成功', 'url' => './categoryList.php']));
} else {
    exit(json_encode(['code' => 0, 'msg' => '抱歉，更新失败', 'url' => './']));
}
