
![avatar](../../resource/img/yii2/application-structure.png)
## MVC
     M 模型代表数据、业务逻辑和规则； 
     V 视图展示模型的输出；
     C 控制器 接受出入并将其转换为模型和视图命令。
## Yii 应用还有以下部分：     
     入口脚本： 终端用户能直接访问的 PHP 脚本， 负责启动一个请求处理周期。
     应用：    能全局范围内访问的对象， 管理协调组件来完成请求.
     应用组件： 在应用中注册的对象， 提供不同的功能来完成请求。
     模块：    包含完整 MVC 结构的独立包， 一个应用可以由多个模块组建。
     过滤器：   控制器在处理请求之前或之后 需要触发执行的代码。
     小部件：   可嵌入到视图中的对象， 可包含控制器逻辑，可被不同视图重复调用
## 生命周期
    当运行 入口脚本 处理请求时， 应用主体会经历以下生命周期:
    
### 入口脚本加载应用主体配置数组。
### 入口脚本创建一个应用主体实例：
    调用 preInit() 配置几个高级别应用主体属性， 比如 basePath。
    注册 error handler 错误处理方法。
    配置应用主体属性。
    调用 init() 初始化，该函数会调用 bootstrap() 运行引导启动组件。
### 入口脚本调用 yii\base\Application::run() 运行应用主体:
    触发 EVENT_BEFORE_REQUEST 事件。
    处理请求：解析请求 路由 和相关参数； 创建路由指定的模块、控制器和动作对应的类，并运行动作。
    触发 EVENT_AFTER_REQUEST 事件。
    发送响应到终端用户。
### 入口脚本接收应用主体传来的退出状态并完成请求的处理。     
     
![avatar](../../resource/img/yii2/application-lifecycle.png)
## 入口脚本  
    每个应用只有一个，负责实例化应用并转发请求到应用    
        WEB应用的入口脚本：@app/web/index.php
        控制台应用的入口脚本：./yii
    
    入口脚本(开头)是定义全局常量的最好地方用来区分其他应用的唯一标识ID
        YII_DEBUG：标识应用是否运行在调试模式
        YII_ENV：标识应用运行的环境，YII_ENV 默认值为 'prod'
## 应用
    每个Yii应用系统只能包含一个应用主体 \Yii::$app,可在应用全局内访问
        WEB应用：(new yii\web\Application($config))->run();
        控制台应用：(new yii\console\Application($config))->run();
    
    必要属性
        id          用来区分其他应用的唯一标识ID
        basePath    指定该应用的根目录,系统预定义 @app 代表这个路径
        
    重要属性
        components  [最重要的属性]它允许你注册多个在其他地方使用的 应用组件
            'components' => [
                'cache' => [
                    'class' => 'yii\caching\FileCache',
                ],
                'user' => [
                    'identityClass' => 'app\models\User',
                    'enableAutoLogin' => true,
                ],
            ],
            在应用中可以任意注册组件，并可以通过表达式 \Yii::$app->ComponentID 全局访问。
            
        aliases     定义别名，代替 Yii::setAlias() 方法来设置—— @app/config/bootstrap.php
        
        bootstrap   它允许你用数组指定启动阶段 bootstrapping process 需要运行的组件
            比如 自定义URL规则、log、debug、gii
            在启动阶段，每个组件都会实例化
            注意：启动太多的组件会降低系统性能，因为每次请求都需要重新运行启动组件，因此谨慎配置启动组件。
    
        catchAll    该属性仅 Web applications 网页应用支持。 
            它指定一个要处理所有用户请求的 控制器方法，
            通常在维护模式下使用，同一个方法处理所有用户请求。
        
        name        指定你可能想展示给终端用户的应用名称,可以不唯一
        
        modules     指定应用所包含的 模块。
            该属性使用数组包含多个模块类 配置，数组的键为模块ID
        
        controllerNamespace 该属性指定控制器类默认的命名空间，默认为Yii::$app->appId\controllers    
        controllerMap   该属性允许你指定一个控制器 ID 到任意控制器类。   
            Yii 遵循一个默认的 规则 指定控制器 ID 到任意控制器类
            （如 post 对应@app\controllers\PostController）
            通过配置这个属性，可以打破这个默认规则
            
        language    指定应用展示给终端用户的语言， 默认为 en 标识英文
            该属性影响各种 国际化 ， 包括信息翻译、日期格式、数字格式等
            推荐遵循 IETF language tag 来设置语言， 例如 en 代表英文， en-US 代表英文(美国).
            
        params      该属性为一个数组，指定可以全局访问的参数， 代替程序中硬编码的数字和字符， 
            应用中的参数定义到一个单独的文件并随时可以访问是一个好习惯    
## 应用事件
    应用在处理请求过程中会触发事件，可以在配置文件配置事件处理代码
        'on eventName' => function ($event) { 要执行的处理 }
    @app/config/main.php配置 如下所示：
    [
        'on beforeRequest' => function ($event) {
            if (some condition) {
                //  设置yii\base\ActionEvent::$isValid 为 false 停止运行后续动作
                $event->isValid = false;
            } else {
                // ...
            }
        },
    ]
    另外，在应用主体实例化后，你可以在 引导启动 阶段附加事件处理代码， 例如：
    \Yii::$app->on(\yii\base\Application::EVENT_BEFORE_REQUEST, function ($event) {
        // ...
    });
  
        在事件触发前，应用主体已经实例化并配置好了
    EVENT_BEFORE_REQUEST
        解析请求 路由 和相关参数； 创建路由指定的模块、控制器和动作对应的类，并运行动作
    EVENT_AFTER_REQUEST
        该事件在应用处理请求 after 之后但在返回响应 before 之前触发
    EVENT_BEFORE_ACTION
        该事件在每个 控制器动作 运行before之前会被触发
        注意 模块 和 控制器 都会触发 beforeAction 事件。 
        应用主体对象首先触发该事件，然后模块触发（如果存在模块），最后控制器触发。 
        任何一个事件处理中设置 yii\base\ActionEvent::$isValid 设置为 false 会停止触发后面的事件。
    EVENT_AFTER_ACTION
        'on afterAction' => function ($event) {
            if (some condition) {
                // 修改 $event->result
            } else {
                //  
            }
        },
        注意 模块 和 控制器 都会触发 afterAction 事件。 
        这些对象的触发顺序和 beforeAction 相反，
        也就是说，控制器最先触发，然后是模块（如果有模块），最后为应用主体。
        
