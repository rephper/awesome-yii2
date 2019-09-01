<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',

    //  请谨慎注册太多应用组件， 应用组件就像全局变量， 使用太多可能加大测试和维护的难度。
    //  一般情况下可以在需要时再创建本地组件。
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];
