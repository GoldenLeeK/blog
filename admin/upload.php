<?php
/**
 * Created by PhpStorm.
 * User: 61458
 * Date: 2019/7/6
 * Time: 13:45
 * wangeditor图片上传
 */
require_once '../autoload.php';
//获取图片
$file = $_FILES['uploadImages'];
$path = '../upload/images';
$uploadTool = new \lib\Upload();
$uploadTool->uploadEditor($file,$path);


