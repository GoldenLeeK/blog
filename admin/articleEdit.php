<?php
/**
 * Created by PhpStorm.
 * User: 61458
 * Date: 2019/7/14
 * Time: 12:22
 * 博客编辑详情页
 */

use libs\Db;

session_start();
if (!isset($_SESSION['user'])) {
    echo "<script>alert('请登陆后访问！');location.href='./login.php'</script>";
}
//自动加载类(smarty)
require dirname(__DIR__) .'/init.inc.php';
$db = Db::getInstance();
//查询所有问文章分类
$cates = $db->table('cates')->lists();
$aid = isset($_GET['aid']) ? $_GET['aid'] : 0;
$article = $db->table('article')->where("id=$aid")->item();
$smarty->assign('ROOT', 'http://192.168.33.10/blog');
$smarty->assign('cates',$cates);
$smarty->assign('article',$article);
$smarty->display('admin_articleEdit.html');
?>

