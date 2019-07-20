<?php
        session_start();
        if (isset($_SESSION['user'])){
            echo "<script>alert('请勿重复登陆');location.href='./index.php'</script>";
        }
//自动加载类
require_once dirname(__DIR__) . '\autoload.php';
?>
<?php include_once './common/title.php'; ?>
    <style>
        body {
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #eee;
        }

        .form-signin {
            max-width: 330px;
            margin: 0 auto;
            padding: 15px;
        }

        .form-signin .form-signin-heading,
        .form-signin .checkbox {
            margin-bottom: 10px;
        }

        .form-signin .form-signin-heading {
            text-align: center;
        }

        .form-signin .checkbox {
            font-weight: normal;
        }

        .form-signin .form-control {
            position: relative;
            height: auto;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            padding: 10px;
            font-size: 16px;
        }

        .form-signin .form-control:focus {
            z-index: 2;
        }

        .form-signin input[type="email"] {
            margin-top: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }

        .form-signin input[type="password"] {
            margin-top: -1px;
            border-top-right-radius: 0;
            border-top-left-radius: 0;
        }

    </style>
</head>
<body>
<div class="container">
    <form class="form-signin">
        <h2 class="form-signin-heading">欢迎登陆</h2>
        <input class="form-control" id="input_user" name="username" type="text" placeholder="请输入账号" autofocus
               autocomplete="off">
        <input class="form-control" type="password" name="password" id="input_pwd" placeholder="请输入密码">
        <div class="checkbox">
            <label>
                <input type="checkbox" name="" id="" value="remmber">记住密码
            </label>
        </div>
        <button class="btn btn-primary btn-lg btn-block" type="button" id="button_login">登陆</button>
    </form>
</div>

<script>
    $(document).ready(function () {
        $("#button_login").click(function () {
            var username = $.trim($("#input_user").val());
            var pwd = $.trim($("#input_pwd").val());
            if (username == '') {
                alert('请输入账号');
                return;
            } else if (pwd == '') {
                alert('请输入密码');
                return;
            }
            $.ajax({
                type: "post",
                url: "../services/dologin.php",
                dataType: "json",
                data: $(".form-signin").serialize(),
                success: function (data) {
                    if (data.code == 1) {
                        alert(data.msg);
                        location.href = data.url;
                    } else {
                        alert(data.msg);
                    }
                },
                //失败的回调函数
                error: function () {
                    alert('登陆失败');
                }
            });
        });
    });
</script>
</body>
</html>