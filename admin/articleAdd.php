<?php
/**
 * Created by PhpStorm.
 * User: 61458
 * Date: 2019/7/5
 * Time: 15:19
 */

use lib\Db;
session_start();

if (!isset($_SESSION['user'])) {
    echo "<script>alert('请登陆后访问！');location.href='./login.php'</script>";
}
require_once '../autoload.php';
$db = Db::getInstance();
//查询所有问文章分类
$cates = $db->table('cates')->lists();

?>

<?php include_once './common/title.php'; ?>
<title>个人博客后台中心</title>

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
                <input type="text" placeholder="请输入文章标题（60位以内）" class="form-control title_input" name="title"
                       autocomplete="off">
                <input type="text" placeholder="请输入文章描述（120位以内）" class="form-control desc_input" name="desc"
                       autocomplete="off">
                <div id="editor">

                </div>
                <div class="col-md-2 col-xs-3">
                    <label for="artical_cate">文章分类：</label>
                    <select name="cate">
                        <option value=0>请选择分类</option>
                        <?php foreach ($cates as $v) { ?>
                            <option value="<?php echo $v['id'] ?>"><?php echo $v['cate_name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-3 col-xs-3">
                    <label for="keyword">文章关键字(逗号隔开)：</label>
                    <input type="text" name="keyword" id="" autocomplete="off">
                </div>
                <div class="col-md-3 col-md-offset-3 col-xs-5 col-xs-offset-1" style="margin-top: 10px;">
                    <button type="button" class="btn  btn-primary" onclick="articleSave()">发布文章</button>
                    <a type="button" class="btn  btn-danger" href="./index.php">返回首页</a>
                </div>
            </form>
        </div>
    </div><!-- 第一行-->
</div>

<?php require_once './common/footer.php' ?>
<script type="text/javascript">
    //初始化富文本编辑器
    var editor;

    function initEditor() {
        var E = window.wangEditor;
        editor = new E('#editor');
        // 或者 var editor = new E( document.getElementById('editor') )
        editor.customConfig.uploadImgServer = './upload.php';  // 上传图片到服务器
        editor.customConfig.uploadFileName = 'uploadImages';//设置上传图片的名字
        editor.customConfig.uploadImgMaxSize = 1 * 1024 * 1024;
        editor.customConfig.customAlert = function (info) {
            // info 是需要提示的内容
            alert('注意：' + info)
        }
        editor.create();
    }

    initEditor();

    //文章保存
    function articleSave() {
        var data = new Object();
        data.title = $.trim($('input[name="title"]').val());
        data.desc = $.trim($('input[name="desc"]').val());
        data.cate = $.trim($('select[name="cate"]').val());
        data.keyword = $.trim($('input[name="keyword"]').val());
        data.content = editor.txt.html();
        //验证数据
        if (data.title == '') {
            alert('文章标题不得为空');
            return;
        }
        if (data.title.length > 60) {
            alert('文章标题不得大于60位');
            return;
        }
        if (data.desc == '') {
            alert('文章的描述不得为空');
            return;
        }
        if (data.desc.length > 120) {
            alert('文章描述不得大于120位');
            return;
        }
        if (data.cate == 0) {
            alert('请选择文章分类');
            return;
        }
        if (data.keyword == '') {
            alert('文章关键字不得为空');
            return;
        }
        $.post('./articleSave.php', data, function (data) {
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
