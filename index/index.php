<?php
/*
	博客首页
*/
namespace index;

use  libs\Db;

session_start();

//自动加载类(smarty)、缓存类
require dirname(__DIR__) . '/init.inc.php';
$db = Db::getInstance();
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$pageSize = 4;
//分类获取文章
$cid = isset($_GET['cid']) ? (int)$_GET['cid'] : 0;
$path = './index.php';
//获取用户信息
$user = $db->table('user')->where('id=1')->limit('')->order('')->item($memcache);
//获取文章分类
$cates = $db->table('cates')->lists($memcache);
//获取文章内容
if ($cid != 0) {
    $data = $db->table('article')->where("article_cate_id = $cid")->order('article_upload_time desc')->pages($page, $pageSize, $path . "?cid=$cid");
} else {
    $data = $db->table('article')->order('article_upload_time desc')->pages($page, $pageSize, $path);
}
//分类标签页按钮样式
$labels = array('btn-default', 'btn-primary', 'btn-success', 'btn-info', 'btn-warning', 'btn-danger');
if ($data['total'] == 0) {
    $data['result'] = array();
}
$memcache->close();
//渲染首页数据
$smarty->assign('ROOT', 'http://192.168.33.10/blog');
$smarty->assign('articles', $data);
$smarty->assign('user', $user);
$smarty->assign('cates', $cates);
$smarty->assign('label', $labels);
$smarty->display('index.html');

?>
