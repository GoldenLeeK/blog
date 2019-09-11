<?php
/**
 * Created by PhpStorm.
 * User: 61458
 * Date: 2019/7/14
 * Time: 12:22
 * 博客分类编辑详情页
 */

use libs\Db;

session_start();
if (!isset($_SESSION['user'])) {
    echo "<script>alert('请登陆后访问！');location.href='./login.php'</script>";
}
//自动加载类(smarty)
require dirname(__DIR__) .'/init.inc.php';
$db = Db::getInstance();
//查询所有问文章分类

$cid = isset($_GET['cid']) ? $_GET['cid'] : 0;
$cate = $db->table('cates')->where("id=$cid")->item();
?>

<?php include_once './common/title.php'; ?>
<title>博客分类编辑</title>
</head>
<body>
<?php require_once './common/header.php' ?>
<!--侧边栏-->
<?php require_once './common/left.php' ?>
<!--主页面-->
<div id="main" class="col-md-9">
    <!-- 第一行-->
    <div class="row">
        <div class="col-sm-9 col-md-9">
            <form action="">
                <input type="text" class="form-control title_input" name="name"
                       value="<?php echo $cate['cate_name'] ?>" required>
                <input type="text" value="<?php echo $cate['id'] ?>" hidden name="id">
                <div class="col-md-3 col-md-offset-3 col-xs-5 col-xs-offset-1" style="margin-top: 10px;">
                    <button type="button" class="btn  btn-primary" onclick="categorySave()">更新分类</button>
                    <a type="button" class="btn  btn-danger" href="./categoryList.php">返回</a>
                </div>
            </form>
        </div>
    </div><!-- 第一行-->
</div>

<?php require_once './common/footer.php' ?>
<script type="text/javascript">

    //文章更新
    function categorySave() {
        var data = new Object();
        data.name = $.trim($('input[name="name"]').val());
        data.id = $.trim($('input[name="id"]').val());

        //验证数据
        if (data.name == '') {
            alert('分类名不得为空');
            return;
        }
        $.post('./categoryUpdate.php', data, function (data) {
            if (data.code == 0) {
                alert(data.msg);
                return;
            }
            alert(data.msg);
            location.href = data.url;
        }, 'json');
    }

</script>

</body>
</html>
