<?php
//  定义全局常量，在require之前定义可以在引入的文件内生效
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

//  注册 Composer 自动加载器
require __DIR__ . '/../../vendor/autoload.php';

//  包含 Yii 类文件
require __DIR__ . '/../../vendor/yiisoft/yii2/Yii.php';

//  加载路径别名配置，当前应用的配置可覆盖全局配置
require __DIR__ . '/../../common/config/bootstrap.php';
require __DIR__ . '/../config/bootstrap.php';

//  加载应用配置
$config = yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/../../common/config/main.php',
    require __DIR__ . '/../../common/config/main-local.php',
    require __DIR__ . '/../config/main.php',
    require __DIR__ . '/../config/main-local.php'
);

//  创建、配置、运行一个应用
(new yii\web\Application($config))->run();
