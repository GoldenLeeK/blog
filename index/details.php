<?php
/**
 * Created by PhpStorm.
 * User: 61458
 * Date: 2019/7/6
 * Time: 16:02
 */

use  lib\Db;
session_start();
//自动加载类
require_once dirname(__DIR__) . '\autoload.php';
$db = Db::getInstance();
//获取文章分类
$cates = $db->table('cates')->lists();
//分类标签页按钮样式
$label = array('btn-primary', 'btn-success', 'btn-info', 'btn-warning', 'btn-default', 'btn-danger');
//获取文章id
$articleId = isset($_GET['aid']) ? $_GET['aid'] : 0;
//浏览量+1
$count = $db->table('article')->filed('article_visit_count')->where("id = $articleId")->item();
if ($count) $count['article_visit_count'] = $count['article_visit_count'] + 1;
$db->table('article')->where("id=$articleId")->update($count);
//获取文章内容
if ($articleId != 0) {
    $article = $db->table('article')->filed('*')->where("id = $articleId")->item();
}
?>
<?php include_once './common/title.php' ?>
    <title><?php if ($article) echo $article['article_title']?></title>
</head>
<body>
<?php include_once "./common/header.php" ?>

<!--content中心内容-->
<div class="container">
    <div>

        <div class="left_content_div col-md-8">
            <?php if (!empty($article)) { ?>
            <h2 style="text-align: center;margin-bottom: 15px;"><?php echo $article['article_title'] ?></h2>
            <div class="col-md-12 col-xs-12">
                <div class="info_box">
                    <span>作者：<?php echo $article['article_author'] ?></span>&nbsp;
                    <span>时间：<?php echo date('Y-m-d H:i:s', $article['article_upload_time']) ?></span>
                    <span>浏览量：<?php echo $article['article_visit_count'] ?>次</span>
                </div>
            </div>
            <hr>
            <div class="col-md-12 " style="margin-top: 15px;">
                <p><?php echo htmlspecialchars_decode($article['article_content']) ?></p>
            </div>
            <hr>
            <div class="col-md-12 comment" style="margin-top: 15px;">
                <div id="lv-container" data-id="city" data-uid="MTAyMC80NTM2OC8yMTg4MQ==">
                </div>
            </div>
        </div>
        <?php }
        else {
            ?>
            <div class="div_error">
                <div class="alert alert-info text-center" role="alert">抱歉，暂时没有文章......</div>
                <a href="./index.php" style="float: right">返回首页</a>
            </div>
        <?php } ?>
    </div>
    <!--    right-->
    <?php include_once "./common/right.php" ?>
</div>
<!--/content-->

<!--footer-->
<?php include_once "./common/footer.php" ?>
<!--/footer-->
</body>
<script type="text/javascript">
    window.livereOptions = {
        //配置refer
        refer:'www.php.com/details.php?aid=<?php echo $article['id']?>'
    };
    (function(d, s) {
        var j, e = d.getElementsByTagName(s)[0];

        if (typeof LivereTower === 'function') { return; }

        j = d.createElement(s);
        j.src = 'https://cdn-city.livere.com/js/embed.dist.js';
        j.async = true;

        e.parentNode.insertBefore(j, e);
    })(document, 'script');
</script>
<noscript> 为正常使用来必力评论功能请激活JavaScript</noscript>

<!-- City版安装代码已完成 -->

</html>
