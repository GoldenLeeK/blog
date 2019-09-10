<?php
/**
 * Created by PhpStorm.
 * User: 61458
 * Date: 2019/7/14
 * Time: 14:45
 * 博客文章删除
 */

use libs\Db;
require_once '../autoload.php';
session_start();
header('Content-Type:application/json');
if (!isset($_SESSION['user'])) {
    echo "<script>alert('请登陆后访问！');location.href='./login.php'</script>";
}

$db = Db::getInstance();
$aid = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($db->table('article')->where("id=$aid")->delete()) {
    exit(json_encode(['code' => 1, 'msg' => '删除成功', 'url' => './']));
}
exit(json_encode(['code' => 0, 'msg' => '删除失败', 'url' => './']));
