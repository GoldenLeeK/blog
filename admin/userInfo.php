<?php
/**
 * Created by PhpStorm.
 * User: 61458
 * Date: 2019/7/5
 * Time: 15:19
 * 个人信息配置
 */

session_start();
//自动加载类(smarty)
require dirname(__DIR__) .'/init.inc.php';

use libs\Db;

if (!isset($_SESSION['user'])) {
    echo "<script>alert('请登陆后访问！');location.href='./login.php'</script>";
}
$db = Db::getInstance();
$id = $_SESSION['user']['id'];
$user = $db->table('user')->where("id=$id")->item();
$smarty->assign('ROOT', 'http://192.168.33.10/blog');
$smarty->assign('user',$user);
$smarty->display('admin_userinfo.html');
?>
