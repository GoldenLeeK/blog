<?php
/*
	博客首页
*/
namespace index;

use  libs\Db;


session_start();
//自动加载类
require_once dirname(__DIR__) . '/autoload.php';
$db = Db::getInstance();
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$pageSize = 4;
//分类获取文章
$cid = isset($_GET['cid']) ? (int)$_GET['cid'] : 0;
$path = './index.php';

//获取文章分类
$cates = $db->table('cates')->lists();
//获取文章内容
if ($cid != 0) {
    $data = $db->table('article')->where("article_cate_id = $cid")->order('article_upload_time desc')->pages($page, $pageSize, $path . "?cid=$cid");
} else {
    $data = $db->table('article')->order('article_upload_time desc')->pages($page, $pageSize, $path);
}
//分类标签页按钮样式
$label = array('btn-primary', 'btn-success', 'btn-info', 'btn-warning', 'btn-default', 'btn-danger');
?>
<?php include_once './common/title.php' ?>
    <title>个人博客</title>

</head>
<body>
<?php include_once "./common/header.php" ?>

<!--content中心内容-->
<div class="container">
    <div>
        <div class="left_content_div col-md-8">
            <?php
            if (!empty($data['result'])) {
                foreach ($data['result'] as $article) { ?>
                    <div class="article">
                        <h3>
                            <a href="./details.php?aid=<?php echo $article['id'] ?>"><?php echo $article['article_title'] ?></a>
                        </h3>
                        <p>
                            <?php echo $article['article_desc'] ?>
                        </p>
                        <div class="info_box">
                            <span>作者：<?php echo $article['article_author'] ?></span>&nbsp;
                            <span>时间：<?php echo date('Y-m-d H:i:s', $article['article_upload_time']) ?></span>
                            <span>浏览量：<?php echo $article['article_visit_count'] ?>次</span>
                        </div>
                    </div>

                <?php }
            } else {
                ?>
                <div class="div_error">
                    <div class="alert alert-info text-center" role="alert">抱歉，暂时没有文章......</div>
                    <a href="./index.php" style="float: right">返回首页</a>
                </div>
            <?php } ?>
        </div>

    </div>
    <!--    right-->
    <?php include_once "./common/right.php" ?>
</div>
<!--分页-->
<div>
    <?php echo $data['pages']; ?>
</div>
<!--/content-->

<!--footer-->
<?php include_once "./common/footer.php" ?>
<!--/footer-->
</body>

</html>