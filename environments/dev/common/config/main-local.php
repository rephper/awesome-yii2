<?php
return [
    //  组件配置，第一次使用 \Yii::$app->componentID 表达式时会创建对应组件实例
    'components' => [
        //  使用配置数组注册组件
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=yii2advanced',
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],

        //  使用类名注册 "cache" 组件
//        'cache' => 'yii\caching\FileCache'
        //  使用函数注册"search" 组件
//        'search' => function () {
//            return new app\components\SolrService;
//        },

    ],
];
