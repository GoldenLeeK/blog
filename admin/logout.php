<?php
/**
 * Created by PhpStorm.
 * User: 61458
 * Date: 2019/7/5
 * Time: 16:10
 */

session_start();
//清除session
if ($_SESSION['user']){
    $_SESSION['user'] = null;
    header("Location:./login.php");
}
