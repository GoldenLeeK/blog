<?php
/**
 * Created by PhpStorm.
 * User: 61458
 * Date: 2019/7/6
 * Time: 13:45
 * wangeditor图片上传
 */
//自动加载类(smarty)
require dirname(__DIR__) .'/init.inc.php';
//获取图片
$file = $_FILES['uploadImages'];
$path = '../upload/images';
$uploadTool = new \libs\Upload();
$uploadTool->uploadEditor($file,$path);


