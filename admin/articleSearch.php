<?php
/**
 * Created by PhpStorm.
 * User: 61458
 * Date: 2019/7/14
 * Time: 12:00
 * 博客管理
 */

use libs\Db;

session_start();
//自动加载类(smarty)
require dirname(__DIR__) .'/init.inc.php';
if (!isset($_SESSION['user'])) {
    echo "<script>alert('请登陆后访问！');location.href='./login.php'</script>";
}
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$pageSize = 7;
$path = './articleSearch.php';
$articles = null;
$startTime = isset($_POST['start']) ? strtotime(trim($_POST['start'])) : 0;
$endTime = isset($_POST['end']) ? strtotime(trim($_POST['end'])) : 0;
if ($startTime > $endTime) echo "<script>alert('输入日期非法，请重新输入')</script>";
if ($startTime && $endTime ){
    //获取时间段文章
    $articles = Db::getInstance()->table('article')->filed('id,article_title')->where("article_upload_time between $startTime and $endTime")->pages($page, $pageSize, $path);
}else{
    //获取所有文章
    $articles = Db::getInstance()->table('article')->filed('id,article_title')->pages($page, $pageSize, $path);
}
$smarty->assign('ROOT', 'http://192.168.33.10/blog');
$smarty->assign('articles',$articles);
$smarty->display('admin_articleSearch.html');


?>
