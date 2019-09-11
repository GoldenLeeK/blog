<?php
/**
 * Created by PhpStorm.
 * User: 61458
 * Date: 2019/7/18
 * Time: 13:30
 * 用户信息保存
 */
session_start();
//自动加载类(smarty)
require dirname(__DIR__) .'/init.inc.php';

use libs\Upload;
$tool = new Upload();
if ($_POST) {
    $path = '../upload/images';
    $data['name'] = trim(htmlspecialchars($_POST['name']));
    $data['email'] = trim(htmlspecialchars($_POST['email']));
    $data['profile'] = trim(htmlspecialchars($_POST['profile']));
    $data['sex']  = (int)$_POST['sex'];
    if (strlen($data['name']) > 30) echo "<script>alert('网名不得超过30位');location.href='userinfo.php'</script>";
    if (strlen($data['profile'] > 60)) echo "<script>alert('网名不得超过30位');location.href='userinfo.php'</script>";
    $result  = $tool->uploadImg($_FILES['uploadImages'],$path);
    //当前用户id
    $userId = (int)$_SESSION['user']['id'];
    if ($result['code'] == 1){
        $data['logo'] = $result['url'];
        $row = \libs\Db::getInstance()->table('user')->where("id=$userId")->update($data);
        echo "<script>alert('恭喜你，更新成功');location.href='userinfo.php'</script>";
    }
    if ($result['code'] == -1){
        $row = \libs\Db::getInstance()->table('user')->where("id=$userId")->update($data);
        echo "<script>alert('恭喜你，更新成功');location.href='userinfo.php'</script>";
    }
    if ($result['code'] == 0){
        echo "<script>alert('抱歉，更新失败');location.href='userinfo.php'</script>";
    }









}