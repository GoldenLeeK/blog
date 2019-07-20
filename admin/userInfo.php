<?php
/**
 * Created by PhpStorm.
 * User: 61458
 * Date: 2019/7/5
 * Time: 15:19
 * 个人信息配置
 */

session_start();
require_once '../autoload.php';

use lib\Db;

if (!isset($_SESSION['user'])) {
    echo "<script>alert('请登陆后访问！');location.href='./login.php'</script>";
}
$db = Db::getInstance();
$id = $_SESSION['user']['id'];
$user = $db->table('user')->where("id=$id")->item();
?>
<?php include_once './common/title.php'; ?>
<title>个人信息中心</title>
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
    <?php require_once './common/header.php'; ?>
    <!--侧边栏-->
    <?php require_once './common/left.php'; ?>
    <!--主页面-->
    <div id="main">
        <form action="./userSave.php" class="form-horizontal form-group" enctype="multipart/form-data" method="post">
            <div class="">
                <label for="preview">头像:</label>
                <div>
                    <img src="<?php echo $user['logo'] ?>" alt="" style="width: 80px;height: 80px;" id="preview">
                    <input type="file" name="uploadImages" id="img" accept="image/png,image/jpeg"
                           onchange="imgPreview(this)">
                </div>
                <label for="name">博主网名</label>
                <input type="text" name="name" id="" class="form-control" style="width: 30%"
                       value="<?php echo $user['name'] ?>" required>
                <label for="">博主性别</label>
                <div>
                    <select name="sex">
                        <?php if ($user['sex'] == 0) { ?>
                            <option value="0" selected>男</option>
                            <option value="1">女</option>
                            <option value="-1">保密</option>
                        <?php } ?>
                        <?php if ($user['sex'] == 1) { ?>
                            <option value="0">男</option>
                            <option value="1" selected>女</option>
                            <option value="3">保密</option>
                        <?php } ?>
                        <?php if ($user['sex'] == -1) { ?>
                            <option value="0">男</option>
                            <option value="1">女</option>
                            <option value="-1" selected>保密</option>
                        <?php } ?>

                    </select>
                </div>

                <label for="">电子邮箱</label>
                <input type="email" name="email" id="" class="form-control" style="width: 30%"
                       value="<?php echo $user['email'] ?>" required>
                <label for="">博主个人简介</label>
                <textarea name="profile" id="" class="form-control" rows="3"
                          style="width: 50%;"><?php echo $user['profile'] ?></textarea>
            </div>
            <button class="btn btn-primary">更改信息</button>
            <a class="btn btn-danger" href="index.php">返回首页</a>
        </form>
    </div>

    <?php require_once './common/footer.php' ?>
</div>
<!--    //图片预览-->
<script type="text/javascript">
    function imgPreview(fileDom) {
        //判断是否支持FileReader
        if (window.FileReader) {
            var reader = new FileReader();
        } else {
            alert("您的设备不支持图片预览功能，如需该功能请升级您的设备！");
        }
        // 获取文件
        var file = fileDom.files[0];
        var imageType = /^image\//;
        //是否是图片
        if (!imageType.test(file.type)) {
            alert('上传文件类型不允许');
            return;
        }
        //读取完成
        reader.onload = function (e) {
            //获取图片dom
            var img = document.getElementById("preview");
            //图片路径设置为读取的图片
            img.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }


</script>
</body>
</html>
