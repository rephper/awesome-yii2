<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    //  用来区分其他应用的唯一标识ID
    'id' => 'app-frontend',

    //  不同于需要唯一性的 id 属性， 该属性可以不唯一，该属性用于显示应用的用途
    'name' => '指定你可能想展示给终端用户的应用名称',

    //  指定该应用的根目录,系统预定义 @app 代表这个路径
    'basePath' => dirname(__DIR__),

    //  定义别名，代替 Yii::setAlias() 方法来设置—— @app/config/bootstrap.php
    'aliases' => [
        '@name1' => 'path/to/path1',
        '@name2' => 'path/to/path2',
    ],

    //  指定应用启动阶段需要运行的组件，在启动阶段会实例化。
    //  注意：启动太多的组件会降低系统性能，因为每次请求都需要重新运行启动组件，因此谨慎配置启动组件。
    'bootstrap' => ['log'],

    //  该属性仅 Web applications 网页应用支持。指定一个要处理所有用户请求的 控制器方法。
    //  通常在维护模式下使用，同一个方法处理所有用户请求。
    //  当开启这个属性时，开发环境下的调试面板将不能工作。
    'catchAll' => [
        'offline/notice',
        'param1' => 'value1',
        'param2' => 'value2',
    ],

    //  该属性指定控制器类默认的命名空间
    'controllerNamespace' => 'frontend\controllers',
    //  使用这个配置可以打破 Yii2 默认的URL规则
//    'controllerMap' => [
//        Yii::$app->controllerId => @app\controllers\xxxIdController,
//        Yii::$app->controllerId => @app\controllers\groupName\xxxIdController,
//    ],

    //  组件配置，通过表达式 \Yii::$app->ComponentID 全局访问
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
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],

    //  指定应用所包含的 模块
    'modules' => [
        // Yii::$app->moduleId 模块以及对应的Module类
        'booking' => 'app\modules\booking\BookingModule',

        // "comment" 模块以及对应的配置数组
        'comment' => [
            'class' => 'app\modules\comment\CommentModule',
            'db' => 'db',
        ],
    ],

    //  数组，指定可以全局访问的参数，代替程序中的魔术数字、文本等
    'params' => $params,

    //  指定应用展示给终端用户的语言， 默认为 en 标识英文。 如果需要之前其他语言可以配置该属性。
    //  该属性影响各种 国际化 ， 包括信息翻译、日期格式、数字格式等
    'language' => 'en',
    //  指定应用代码的语言,默认为 'en-US' 标识英文（美国）
    'sourceLanguage' => 'en-US',

    //  该属性提供一种方式修改 PHP 运行环境中的默认时区，
    //  配置该属性本质上就是调用 PHP 函数 date_default_timezone_set()
    'timeZone' => 'America/Los_Angeles',

    //  指定应用的版本，默认为 '1.0',可用于更新静态资源
    'version' => '1.0',

    //  指定应用使用的字符集，默认值为 'UTF-8'，
    //  绝大部分应用都在使用，除非已有的系统大量使用非unicode数据才需要更改该属性
    'charset' => 'UTF-8',

    //  指定未配置的请求的响应 路由 规则
    //  如果动作 ID 没有指定， 会使用 yii\base\Controller::$defaultAction 中指定的默认值(index)
    //  对于 WEB应用， 默认值为 'site/index'
//    'defaultRoute' => '[moduleId/]controllerId/actonId',
    //  对于控制台(console)应用,默认值为help,对应 yii\console\controllers\HelpController::actionIndex()
    //  因此根目录下执行 php yii 会显示帮助信息

    //  用数组列表指定应用安装和使用的 扩展, 默认使用 @vendor/yiisoft/extensions.php 文件返回的数组
    //  当你使用 Composer 安装扩展，extensions.php 会被自动生成和维护更新。
    //  所以大多数情况下，不需要配置该属性。
//    'extensions' => [];

    //  指定渲染 视图 默认使用的布局名字，默认值为 'main'
    //  对应布局路径下的 main.php 文件 —— @app/views/layouts/main.php
    'layout' => 'main',

    //  指定查找布局文件的路径,该属性需要配置成一个目录或 路径 别名
    'layoutPath' => '@app/views/layouts',
    //  指定临时文件如日志文件、缓存文件等保存路径,默认值为带别名的
    'runtimePath' => '@app/runtime',
    //  指定视图文件的根目录
    'viewPath' => '@app/views',
    //  指定 Composer 管理的供应商路径
    'vendorPath' => '@app/vendor',

    //   仅控制台应用支持， 用来指定是否启用 Yii 中的核心命令，默认值为 true
//    'enableCoreCommands' => true,

    //  应用事件
    'on eventName' => function ($event) {
        // ...
    },
];
