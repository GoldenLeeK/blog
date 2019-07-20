<?php
/**
 * Created by PhpStorm.
 * User: 61458
 * Date: 2019/7/14
 * Time: 12:00
 * 博客管理
 */

use lib\Db;

session_start();
require_once '../autoload.php';
if (!isset($_SESSION['user'])) {
    echo "<script>alert('请登陆后访问！');location.href='./login.php'</script>";
}
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$pageSize = 7;
$path = './articleSearch.php';

$startTime = isset($_POST['start']) ? strtotime(trim($_POST['start'])) : 0;
$endTime = isset($_POST['end']) ? strtotime(trim($_POST['end'])) : 0;
if ($startTime > $endTime) echo "<script>alert('输入日期非法，请重新输入')</script>";
if ($startTime && $endTime ){
    //获取时间段文章
    $articles = Db::getInstance()->table('article')->filed('id,article_title')->where("article_upload_time between $startTime and $endTime")->pages($page, $pageSize, $path);
}else{
    //获取所有文章
    $articles = Db::getInstance()->table('article')->filed('id,article_title')->pages($page, $pageSize, $path);
}



?>
<!doctype html>
<html lang="en">
<head>
    <
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../statics/css/bootstrap.min.css">
    <link href="../statics/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <script src="../statics/js/jquery.min.js"></script>
    <script src="../statics/js/moment-with-locales.min.js"></script>
    <script src="../statics/js/bootstrap.min.js"></script>
    <script src="../statics/js/bootstrap-datetimepicker.min.js"></script>


    <!-- 以下两个插件用于在IE8以及以下版本浏览器支持HTML5元素和媒体查询，如果不需要用可以移除 -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>

    <![endif]-->
    <title>博客列表</title>
    <style>
        #sidebar {
            width: 200px;
            position: absolute;
            z-index: 1;
        }

        #main {
            margin-left: 210px;
            margin-right: 10px;
            width: 1200px;
            margin-top: 74px;
        }
    </style>
</head>
<body>
<div class="row">
    <?php require_once './common/header.php' ?>
    <!--侧边栏-->
    <?php require_once './common/left.php' ?>
    <!--主页面-->
    <div id="main">
        <div class="row">
            <form action="./articleSearch.php" method="post">
                <div class='col-md-4'>
                    <div class="form-group">
                        <div class='input-group date' id='datetimepicker1'>
                            <input type='text' class="form-control" placeholder="开始时间" name="start" autocomplete="off"/>
                            <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                        </div>
                    </div>
                </div>
                <div class='col-md-4'>
                    <div class="form-group">
                        <div class='input-group date' id='datetimepicker2'>
                            <input type='text' class="form-control" placeholder="结束时间" name="end" autocomplete="off"/ >
                            <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                        </div>
                    </div>
                </div>
                <button class="col-md-2 btn" type="submit">搜索</button>
            </form>
        </div>
        <table class="table table-bordered ">
            <tr>
                <th>博客id</th>
                <th>博客标题</th>
                <th>操作</th>
            </tr>
            <?php
            foreach ($articles['result'] as $v) { ?>
                <tr class="article_tr_<?php echo $v['id'] ?>">
                    <td><?php echo $v['id'] ?></td>
                    <td><a href="./articleEdit.php?aid=<?php echo $v['id'] ?>"><?php echo $v['article_title'] ?></a>
                    </td>
                    <td>
                        <a class="btn btn-primary" style="margin-right: 15px;"
                           href="./articleEdit.php?aid=<?php echo $v['id'] ?>">编辑</a>
                        <a class="btn btn-danger" onclick="articleDel(<?php echo $v['id']; ?>)">删除</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <!--        分页-->
        <div class="text-center"><?php echo $articles['pages']; ?></div>
    </div>

    <?php require_once './common/footer.php' ?>
</div>
<script>
    // 时间选择
    $('#datetimepicker1').datetimepicker({
        locale: moment().locale('zh-cn')
    });
    $('#datetimepicker2').datetimepicker({
        locale: moment().locale('zh-cn')
    });


    // ajax删除博客
    function articleDel(id) {
        flag = confirm('确定删除文章吗?');
        if (flag) {
            $.get('articleDel.php', {id: id}, function (data) {
                if (data.code == 1) {
                    $('.article_tr_' + id).remove();
                    alert(data.msg);
                }
                if (data.code == 0) {
                    alert(data.msg);
                }
            });
        }
    }
</script>
</body>
</html>
