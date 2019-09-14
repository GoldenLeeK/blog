<?php
/**
 * Created by PhpStorm.
 * User: 61458
 * Date: 2019/7/14
 * Time: 12:00
 * 博客分类管理
 */

use libs\Db;

session_start();
//自动加载类(smarty)
require dirname(__DIR__) .'/init.inc.php';
if (!isset($_SESSION['user'])) {
    echo "<script>alert('请登陆后访问！');location.href='./login.php'</script>";
}
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$pageSize = 5;
$path = './categoryList.php';

//获取分类
$cates = Db::getInstance()->table('cates')->filed('id,cate_name')->pages($page, $pageSize, $path);
$smarty->assign('ROOT', 'http://192.168.33.10/blog');
$smarty->assign('cates',$cates);
$smarty->display('admin_categoryList.html');
?>
