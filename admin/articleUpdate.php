<?php
/**
 * Created by PhpStorm.
 * User: 61458
 * Date: 2019/7/6
 * Time: 12:52
 * 保存博客文章
 */

namespace libs;
session_start();
//自动加载类(smarty)
require dirname(__DIR__) .'/init.inc.php';
//接收前端发过来的数据
$id = (int)$_POST['id'];
$data['article_title'] = htmlspecialchars(trim($_POST['title']), true);
$data['article_desc'] = htmlspecialchars(trim($_POST['desc']), true);
$data['article_content'] = htmlspecialchars($_POST['content'], true);
$data['article_keyword'] = htmlspecialchars(trim($_POST['title']), true);
$data['article_cate_id'] = (int)$_POST['cate'];
//设置时区
$data['article_upload_time'] = time() + (8 * 60 * 60);
$data['article_author'] = $_SESSION['user']['name'];
//获取文章id

//插入数据库
$db = Db::getInstance();
if ($db->table('article')->where("id=$id")->update($data)){
    exit(json_encode(['code' => 1, 'msg' => '恭喜你，更新成功', 'url' => './']));
} else {
    exit(json_encode(['code' => 0, 'msg' => '抱歉，更新失败', 'url' => './']));
}
