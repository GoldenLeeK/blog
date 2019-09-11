<?php
/**
 * Created by PhpStorm.
 * User: 61458
 * Date: 2019/7/14
 * Time: 12:00
 * 博客分类管理
 */

use libs\Db;

session_start();
//自动加载类(smarty)
require dirname(__DIR__) .'/init.inc.php';
if (!isset($_SESSION['user'])) {
    echo "<script>alert('请登陆后访问！');location.href='./login.php'</script>";
}
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$pageSize = 5;
$path = './categoryList.php';

//获取分类
$cates = Db::getInstance()->table('cates')->filed('id,cate_name')->pages($page, $pageSize, $path);

?>
<?php include_once './common/title.php'; ?>
<title>博客分类管理</title>
</head>
<body>
<div class="row">
    <?php require_once './common/header.php' ?>
    <!--侧边栏-->
    <?php require_once './common/left.php' ?>
    <!--主页面-->
    <div id="main">
        <a class="btn btn-primary" href="./categoryAdd.php">增加</a>
        <table class="table table-bordered ">
            <tr>
                <th>分类id</th>
                <th>分类名字</th>
                <th>操作</th>
            </tr>
            <?php
            foreach ($cates['result'] as $v) { ?>
                <tr class="article_tr_<?php echo $v['id'] ?>">
                    <td><?php echo $v['id'] ?></td>
                    <td><a href="./categoryEdit.php?cid=<?php echo $v['id'] ?>"><?php echo $v['cate_name'] ?></a>
                    </td>
                    <td>
                        <a class="btn btn-primary" style="margin-right: 15px;"
                           href="./categoryEdit.php?cid=<?php echo $v['id'] ?>">编辑</a>
                        <a class="btn btn-danger" onclick="articleDel(<?php echo $v['id']; ?>)">删除</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <!--        分页-->
        <div class="text-center"><?php echo $cates['pages']; ?></div>
    </div>

    <?php require_once './common/footer.php' ?>
</div>
<script>
    // ajax删除博客
    function articleDel(id) {
        flag = confirm('确定删除该分类吗?');
        if (flag) {
            $.get('categoryDel.php', {id: id}, function (data) {
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
