<?php
/**
 * Created by PhpStorm.
 * User: 61458
 * Date: 2019/7/18
 * Time: 12:05
 */
use lib\Config;

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?php echo Config::__root__?>/statics/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo Config::__root__?>/statics/css/main.css">
    <script src="<?php echo Config::__root__?>/statics/js/jquery.min.js"></script>
    <script src="<?php echo Config::__root__?>/statics/js/bootstrap.min.js"></script>
    <script src="//unpkg.com/wangeditor/release/wangEditor.min.js"></script>
    <!-- 以下两个插件用于在IE8以及以下版本浏览器支持HTML5元素和媒体查询，如果不需要用可以移除 -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
