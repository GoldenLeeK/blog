<?php
/**
 * Created by PhpStorm.
 * User: 61458
 * Date: 2019/7/5
 * Time: 14:39
 */
/*
 * 登陆接口
 * @param string username 用户账号 string password 用户密码
 * @reuturn json code:状态码（0失败1成功） msg:返回信息 url:跳转地址
 */
namespace lib;
header('Content-Type:application/json');
$username = trim($_POST['username']);
$password = trim($_POST['password']);

require_once dirname(__DIR__) . '\autoload.php';
$db = Db::getInstance();
$user = $db->table('user')->where(['username'=>$username])->item();;
if (!$user){
    //用户不存在，返回json数据
    exit(json_encode(['code'=>0,'msg'=>'你输入的用户不存在','url'=>'./login.php']));
}
//验证密码
if ($user['password'] != md5($password)){
    exit(json_encode(['code'=>0,'msg'=>'你输入的密码不正确','url'=>'./login.php']));
}else{
    session_start();
    $_SESSION['user'] = $user;
    exit(json_encode(['code'=>'1','msg'=>'恭喜你，登陆成功','url'=>'./index.php']));
}


