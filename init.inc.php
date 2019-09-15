<?php

/**
 * Created by PhpStorm.
 * User: 61458
 * Date: 2019/9/10
 * Time: 15:36
 */
define('ROOT', str_replace('\\', '/', dirname(__FILE__)) . '/');
require ROOT . 'libs/Smarty.class.php';
//smarty引擎
$smarty = new Smarty();
$smarty->caching = false;
$smarty->setTemplateDir(ROOT . 'index/view')
        ->addTemplateDir(ROOT . 'admin/view')
        ->setCompileDir(ROOT . 'view_c')
        ->setPluginsDir(ROOT . 'libs/plugins')
        ->setCacheDir(ROOT.'view_cache')
        ->setConfigDir(ROOT . 'smarty_configs');

$smarty->cache_lifetime = 60 * 60 * 24;
//memcache缓存
$memcache = new \Memcache();
$memcache->connect('localhost',11211);







