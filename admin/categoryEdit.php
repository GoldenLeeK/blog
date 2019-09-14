<?php
/**
 * Created by PhpStorm.
 * User: 61458
 * Date: 2019/7/14
 * Time: 12:22
 * 博客分类编辑详情页
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
$cid = isset($_GET['cid']) ? $_GET['cid'] : 0;
$cate = $db->table('cates')->where("id=$cid")->item();
$smarty->assign('ROOT', 'http://192.168.33.10/blog');
$smarty->assign('cate',$cate);
$smarty->display('admin_categoryEdit.html');
?>


