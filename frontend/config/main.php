<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
        'guide' => [
            'basePath' => '@frontend/modules/guide',
            'class' => 'frontend\modules\guide\Module',
        ],

        'linux' => [
            'basePath' => '@frontend/modules/linux',
            'class' => 'frontend\modules\linux\Module',
        ],
        'nginx' => [
            'basePath' => '@frontend/modules/nginx',
            'class' => 'frontend\modules\nginx\Module',
        ],
        'mysql' => [
            'basePath' => '@frontend/modules/mysql',
            'class' => 'frontend\modules\mysql\Module',
        ],
        'php' => [
            'basePath' => '@frontend/modules/php',
            'class' => 'frontend\modules\php\Module',
        ],

        'redis' => [
            'basePath' => '@frontend/modules/redis',
            'class' => 'frontend\modules\redis\Module',
        ],

    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules'=>[
                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
//                '<module:\w+>/<controller:\w+>/<action:\w+>'=>'<module>/<controller>/<action>'
            ],
        ],

    ],
    'params' => $params,
];
