<!--nav顶部导航-->
<nav class="navbar navbar-fixed-top navbar-inverse">
    <div class="container">
        <div class="navbar-header">
            <button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false"
                    aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="" class="navbar-brand">小黄鸡博客</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav pull-right">
                <li class="" id="blog/index/index.php"><a href="./index.php"><span
                                class="glyphicon glyphicon-home"></span> 首页</a></li>
                <li class=""><a href="javascript:void(0);"><span class="glyphicon glyphicon-globe"></span>
                        欢迎你,<?php echo $_SESSION['user']['username'] ?></a></li>
                <li class=""><a href="./logout.php" onClick="return confirm('确定退出系统吗?');"><span
                                class="glyphicon glyphicon-home" ></span> 退出</a></li>
            </ul>
        </div>
    </div>
</nav>
