<?php
/**
 * Created by PhpStorm.
 * User: 61458
 * Date: 2019/7/5
 * Time: 15:19
 */

//自动加载类
require_once dirname(__DIR__) . '\autoload.php';

session_start();
    if (!isset($_SESSION['user'])){
        echo "<script>alert('请登陆后访问！');location.href='./login.php'</script>";
    }
?>
<?php include_once './common/title.php'; ?>
    <title>个人博客后台中心</title>
</head>
<body>
<div class="row">
    <?php require_once './common/header.php' ?>
    <!--侧边栏-->
    <?php require_once  './common/left.php'?>
    <!--主页面-->
    <div id="main">


    </div>

    <?php require_once  './common/footer.php'?>
</div>

</body>
</html>
