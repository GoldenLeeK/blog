<?php
/**
 * Created by PhpStorm.
 * User: 61458
 * Date: 2019/7/14
 * Time: 14:45
 * 博客分类删除
 */

use libs\Db;

session_start();
header('Content-Type:application/json');
if (!isset($_SESSION['user'])) {
    echo "<script>alert('请登陆后访问！');location.href='./login.php'</script>";
}
//自动加载类(smarty)
require dirname(__DIR__) .'/init.inc.php';
$db = Db::getInstance();
$cid = isset($_GET['id']) ? $_GET['id'] : 0;
if ($db->table('cates')->where("id=$cid")->delete()) {
    exit(json_encode(['code' => 1, 'msg' => '删除成功', 'url' => './']));
}
exit(json_encode(['code' => 0, 'msg' => '删除失败', 'url' => './']));
