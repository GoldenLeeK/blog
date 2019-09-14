<?php
/**
 * Created by PhpStorm.
 * User: 61458
 * Date: 2019/7/5
 * Time: 15:19
 */

use  libs\Db;

//自动加载类(smarty)
require dirname(__DIR__) . '/init.inc.php';

session_start();
if (!isset($_SESSION['user'])) {
    echo "<script>alert('请登陆后访问！');location.href='./login.php'</script>";
}
$db = Db::getInstance();
$smarty->assign('ROOT', 'http://192.168.33.10/blog');
$smarty->display('admin_index.html');
?>
