<?php
/**
 * Created by PhpStorm.
 * User: 61458
 * Date: 2019/6/26
 * Time: 16:20
 */

function autoload($className){

    $className= ltrim($className, '\\');
    $fileName  = '';
    $namespace = '';
    if ($lastNsPos = strrpos($className, '\\')) {
        $namespace = substr($className, 0, $lastNsPos);
        $className= substr($className, $lastNsPos + 1);
        $fileName  = __DIR__.'/' . str_replace('/', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.class.php';

    require_once $fileName;
}
spl_autoload_register('autoload');