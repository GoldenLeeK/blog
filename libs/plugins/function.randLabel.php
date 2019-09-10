<?php
/**
 * Created by PhpStorm.
 * User: 61458
 * Date: 2019/9/10
 * Time: 17:05
 */
function smarty_function_randLabel($params,$smarty){
    if (isset($params['labels'])&&!empty($params['labels'])){
        $index = array_rand($params['labels']);
    }else{
        $index = 0;
    }
    return $params['labels'][$index];
}