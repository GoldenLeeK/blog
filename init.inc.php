<?php

/**
 * Created by PhpStorm.
 * User: 61458
 * Date: 2019/9/10
 * Time: 15:36
 */
define('ROOT', str_replace('\\', '/', dirname(__FILE__)) . '/');
require ROOT . 'libs/Smarty.class.php';

$smarty = new Smarty();
$smarty->setTemplateDir(ROOT . 'index/view')
        ->addTemplateDir(ROOT . 'admin/view')
        ->setCompileDir(ROOT . 'view_c')
        ->setPluginsDir(ROOT . 'libs/plugins')
        ->setCacheDir('view_cache')
        ->setConfigDir(ROOT . 'smarty_configs');
$smarty->caching = false;
$smarty->cache_lifetime = 60 * 60 * 24;







