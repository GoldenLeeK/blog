<?php
/**
 * Created by PhpStorm.
 * User: 61458
 * Date: 2019/7/6
 * Time: 12:52
 * 保存分类
 */
namespace lib;
session_start();
require_once '../autoload.php';
//接收前端发过来的数据
$data['cate_name'] = htmlspecialchars(trim($_POST['name']),true);

//插入数据库
$db = Db::getInstance();
if ($db->table('cates')->insert($data)) {
    exit(json_encode(['code'=>1,'msg'=>'恭喜你，添加成功','url'=>'./categoryList.php']));
}else{
    exit(json_encode(['code'=>0,'msg'=>'抱歉，添加失败','url'=>'./']));
}
