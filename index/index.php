<?php
/*
	博客首页
*/
namespace index;

use  libs\Db;

session_start();
//加载Smarty初始化类
require dirname(__DIR__) .'/init.inc.php';
//自动加载类
require_once dirname(__DIR__) . '/autoload.php';
$db = Db::getInstance();
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$pageSize = 4;
//分类获取文章
$cid = isset($_GET['cid']) ? (int)$_GET['cid'] : 0;
$path = './index.php';

//获取文章分类
$cates = $db->table('cates')->lists();
//获取文章内容
if ($cid != 0) {
    $data = $db->table('article')->where("article_cate_id = $cid")->order('article_upload_time desc')->pages($page, $pageSize, $path . "?cid=$cid");
} else {
    $data = $db->table('article')->order('article_upload_time desc')->pages($page, $pageSize, $path);
}
//分类标签页按钮样式
$label = array('btn-primary', 'btn-success', 'btn-info', 'btn-warning', 'btn-default', 'btn-danger');
?>
