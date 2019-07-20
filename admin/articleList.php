<?php
/**
 * Created by PhpStorm.
 * User: 61458
 * Date: 2019/7/14
 * Time: 12:00
 * 博客管理
 */

use lib\Db;
use lib\Config;
session_start();
require_once '../autoload.php';
if (!isset($_SESSION['user'])) {
    echo "<script>alert('请登陆后访问！');location.href='./login.php'</script>";
}
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$pageSize = 7;
$path = './articleList.php';

//获取文章
$articles = Db::getInstance()->table('article')->filed('id,article_title')->pages($page, $pageSize, $path);
?>
<?php include_once './common/title.php'; ?>
    <title>个人博客后台中心</title>
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
<script src="<?php echo Config::__root__?>/statics/js/moment-with-locales.min.js"></script>
<script src="<?php echo Config::__root__?>/statics/js/bootstrap-datetimepicker.min.js"></script>
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
        if (flag){
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
