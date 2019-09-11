<?php
/**
 * Created by PhpStorm.
 * User: 61458
 * Date: 2019/9/11
 * Time: 10:26
 * 目标：判断string|array是否为空
 * @param string|array
 * @return boolean true|false
 */
function smarty_function_empty($string){
    return empty($string);
}