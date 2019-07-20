<?php
/**
 * Created by PhpStorm.
 * User: 61458
 * Date: 2019/7/6
 * Time: 15:43
 */
$user = $db->table('user')->filed('name,sex,profile,email,logo')->where('id=1')->limit('')->order('')->item();


?>

<div class="right_content_div col-md-4 hidden-xs pull-right">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">博主信息</h3>
        </div>
        <div class="panel-body">
            <div class="text-center"><img src="<?php echo $user['logo'] ?>" alt="" style="height: 80px;width: 80px;">
                <p><strong><?php echo $user['name'] ?></strong></p></div>
            <hr>
            <p><strong>性别：<?php
                    if ($user['sex'] == 0) {
                        echo '男';
                    }else if ($user['sex'] == 1){
                        echo '女';
                    }else{
                        echo '保密';
                    }
                    ?></strong></p>
            <p><strong>简介:
                    <?php echo $user['profile'] ?></strong>
            </p>
            <p><strong>email：<?php echo $user['email'] ?></strong></p>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">搜索</h3>
        </div>
        <div class="panel-body">
            <form action="./search.php" method="get">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="关键字/标题/作者" name="keyword" required
                           autocomplete="off">
                    <span class="input-group-btn">
                            <button class="btn btn-default" type="submit">搜索</button>
                </span>
            </form>
        </div>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">博客分类</h3>
    </div>
    <div class="panel-body">
        <?php foreach ($cates as $v) { ?>
            <a class="btn <?php echo $label[array_rand($label)] ?>" type="button"
               href="./index.php?cid=<?php echo $v['id'] ?>">
                <?php echo $v['cate_name'] ?>
            </a>
        <?php } ?>
    </div>
</div>

</div>
