<?php
session_start();
if (isset($_SESSION['user'])) {
    echo "<script>alert('请勿重复登陆');location.href='./index.php'</script>";
}
//自动加载类(smarty)
require dirname(__DIR__) . '/init.inc.php';
$smarty->assign('ROOT', 'http://192.168.33.10/blog');
$smarty->display('login.html');
?>
