<?php
/**
 * Created by PhpStorm.
 * User: 61458
 * Date: 2019/7/14
 * Time: 15:22
 * 文章搜索
 */
namespace index;

use  lib\Db;

session_start();
//自动加载类
require_once dirname(__DIR__) . '\autoload.php';
$db = DB::getInstance();
//分类获取文章
$cid = isset($_GET['cid']) ? $_GET['cid'] : 0;
//获取文章分类
$cates = $db->table('cates')->lists();
//分类标签页按钮样式
$label = array('btn-primary', 'btn-success', 'btn-info', 'btn-warning', 'btn-default', 'btn-danger');
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$pageSize = 5;
$path = './search.php';
$length = strlen(trim($_GET['keyword']));
if ($length == 0) {
    echo "<script>alert('请输入搜索内容');location.href='index.php'</script>";
    exit();
}
$keyword = trim(htmlspecialchars($_GET['keyword']));
$data = $db->table('article')->where('article_keyword like ' . "'%" . $keyword . "%'" . 'or '
    . 'article_title like ' . "'%" . $keyword . "%'" . 'or ' .
    'article_author like ' . "'%" . $keyword . "%'"
)->pages($page, $pageSize, $path);

?>
<?php include_once './common/title.php' ?>
    <title>文章搜索</title>
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
                            <span>作者：<?php echo $article['article_author'] ?></span>
                            <span>时间：<?php echo date('Y-m-d H:i:s', $article['article_upload_time']) ?></span>
                            <span>浏览量：<?php echo $article['article_visit_count'] ?>次</span>
                        </div>
                        <hr>
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
<!--<div>-->
<!--    --><?php //echo $data['pages'];
?>
<!--</div>-->
</div>

<!--/content-->

<!--footer-->
<?php include_once "./common/footer.php" ?>
<!--/footer-->
</body>

</html>