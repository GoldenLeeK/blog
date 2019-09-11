<?php
/**
 * Created by PhpStorm.
 * User: 61458
 * Date: 2019/7/14
 * Time: 15:22
 * 文章搜索
 */
namespace index;

use  libs\Db;

session_start();
//自动加载类(smarty)
require dirname(__DIR__) . '/init.inc.php';
$db = DB::getInstance();
//分类获取文章
$cid = isset($_GET['cid']) ? $_GET['cid'] : 0;
//获取文章分类
$cates = $db->table('cates')->lists();
//获取用户信息
$user = $db->table('user')->where('id=1')->limit('')->order('')->item();
//分类标签页按钮样式
$labels = array('btn-primary', 'btn-success', 'btn-info', 'btn-warning', 'btn-default', 'btn-danger');
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$pageSize = 5;
$path = './search.php';
$length = strlen(trim($_GET['keyword']));
if ($length == 0) {
    echo "<script>alert('请输入搜索内容');location.href='index.php'</script>";
    exit();
}
$keyword = trim(htmlspecialchars($_GET['keyword']));
$data = $db->table('article')->where('article_keyword like ' . "'%" . $keyword . "%'" . 'or '
    . 'article_title like ' . "'%" . $keyword . "%'" . 'or ' .
    'article_author like ' . "'%" . $keyword . "%'"
)->pages($page, $pageSize, $path);
if ($data['total'] == 0) {
    $data['result'] = array();
}
//渲染首页数据
$smarty->assign('ROOT', 'http://192.168.33.10/blog');
$smarty->assign('label', $labels);
$smarty->assign('article', $data);
$smarty->assign('user', $user);
$smarty->assign('cates', $cates);
$smarty->display('search.html');
