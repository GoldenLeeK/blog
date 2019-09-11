<?php
/**
 * Created by PhpStorm.
 * User: 61458
 * Date: 2019/7/6
 * Time: 16:02
 */

use  libs\Db;

session_start();
//自动加载类(smarty)
require dirname(__DIR__) . '/init.inc.php';
$article = null;
$db = Db::getInstance();
//获取文章分类
$cates = $db->table('cates')->lists();
//获取用户信息
$user = $db->table('user')->where('id=1')->limit('')->order('')->item();
//分类标签页按钮样式
$labels = array('btn-primary', 'btn-success', 'btn-info', 'btn-warning', 'btn-default', 'btn-danger');
//获取文章id
$articleId = isset($_GET['aid']) ? $_GET['aid'] : 0;

//浏览量+1
$count = $db->table('article')->filed('article_visit_count')->where("id = $articleId")->item();
if ($count) $count['article_visit_count'] = $count['article_visit_count'] + 1;
$db->table('article')->where("id=$articleId")->update($count);
//获取文章内容
if ($articleId != 0) {
    $article = $db->table('article')->filed('*')->where("id = $articleId")->item();
}
//渲染首页数据
$smarty->assign('ROOT', 'http://192.168.33.10/blog');
$smarty->assign('label', $labels);
$smarty->assign('article', $article);
$smarty->assign('user', $user);
$smarty->assign('cates', $cates);
$smarty->display('details.html');
