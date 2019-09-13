# 结构总览
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
    
### 应用主体属性    
    必要属性
        id          用来区分其他应用的唯一标识ID
        basePath    指定该应用的根目录,系统预定义 @app 代表这个路径
        
    重要属性
        aliases     定义别名，代替 Yii::setAlias() 方法来设置—— @app/config/bootstrap.php
        
        bootstrap   它允许你用数组指定启动阶段 bootstrapping process 需要运行的组件
            比如 自定义URL规则、log、debug、gii
            在启动阶段，每个组件都会实例化
            注意：启动太多的组件会降低系统性能，因为每次请求都需要重新运行启动组件，因此谨慎配置启动组件。
    
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
### 应用事件
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
        
## 应用组件
    应用主体是服务定位器， 它部署一组提供各种不同功能的 应用组件 来处理请求
    在同一个应用中，每个应用组件都有一个独一无二的 ID 用来区分其他应用组件 \Yii::$app->componentID
    例如，urlManager组件负责处理网页请求路由到对应的控制器。 db组件(\Yii::$app->db)提供数据库相关服务等等。
    [*]components组件是懒加载，bootstrap在初始化应用时就会加载
    第一次使用以上表达式时候会创建应用组件实例， 后续再访问会返回此实例，无需再次创建
    请谨慎注册太多应用组件， 应用组件就像全局变量， 使用太多可能加大测试和维护的难度。 
    一般情况下可以在需要时再创建本地组件。
    应用组件可以是任意对象，可以在 应用主体配置配置 yii\base\Application::$components 属性
         
### 核心应用组件
    Yii 定义了一组固定ID和默认配置的 核心 组件：
    assetManager: 管理资源包和资源发布。
    db: 代表一个可以执行数据库操作的数据库连接， 注意配置该组件时必须指定组件类名和其他相关组件属性。
    errorHandler: 处理 PHP 错误和异常。
    formatter: 格式化输出显示给终端用户的数据，例如数字可能要带分隔符， 日期使用长格式。
    i18n: 支持信息翻译和格式化。
    log: 管理日志对象。 
    mail: 支持生成邮件结构并发送。
    response: 代表发送给用户的响应。
    request: 代表从终端用户处接收到的请求。
    session: 代表会话信息， 仅在Web applications 网页应用中可用。 
    urlManager: 支持URL地址解析和创建。 
    user: 代表认证登录用户信息， 仅在Web applications 网页应用中可用。
    view: 支持渲染视图。
    
## 控制器
    webController extends yii\base\Controller
    consoleController extends yii\console\Controller
    控制器从应用主体 接管控制后会分析请求数据并传送到模型， 传送模型结果到视图，最后生成输出响应信息。
    命名规则：控制器ID应仅包含英文小写字母、数字、下划线、中横杠和正斜杠
    控制器Id可包含子目录前缀
    子目录前缀可为英文大小写字母、数字、下划线、正斜杠，其中正斜杠用来区分多级子目录(如 panels/admin)

    在不使用模块时可以通过目录分组管理控制器
    @app\controllers\[ModuleID\]FirstSeccontroller 对应路由规则为 [ModuleID/]first-sec
    @app\controllers\[subDir\]FirstSeccontroller 对应路由规则为 [subDir/]first-sec
### 动作    
#### 内联动作
    在控制器中的 actionXxx(){ //动作 }
    actionID应仅包含英文小写字母、数字、下划线和中横杠，操作ID中的中横杠用来分隔单词
    ControllerIDController/actionXxxYyy对应的路径规则为 ControllerID/xxx-yyy
    
    操作方法的名字大小写敏感，
    如果方法名称为ActionIndex不会认为是操作方法， 所以请求index操作会返回一个异常，
    也要注意操作方法必须是公有的， 私有或者受保护的方法不能定义成内联操作
    
    controller内部可以指定默认action,默认为index
    public $defaultAction = 'home';
#### 独立动作
    singleAction extends yii\base\Action或它的子类的类，主要用于多个控制器重用，或重构为扩展
    例如Yii发布的yii\web\ViewAction 和yii\web\ErrorAction都是独立操作。
    要使用独立操作，需要通过控制器中覆盖yii\base\Controller::actions()方法在action map中申明， 如下例所示：
    
## 模型
    xxxModel extends yii\base\Model 或Model 的子类
    xxxModel extends yii\db\ActiveRecord 
    模型是代表业务数据、规则和逻辑的对象
    模型通过 属性 来代表业务数据，每个属性像是模型的公有可访问属性
    public function attributes() 指定模型所拥有的属性
    //  明确指定属性标签, 便于视图中显示
    public function attributeLabels() {
        //  应用支持多语言的情况下，可翻译属性标签
        'name' => \Yii::t('app', 'Your name'),
        //  甚至可以根据条件定义标签
        'body' => function() {
            if ($this->scenario) {}
        }
    }
    //  定义不同场景需要验证的属性，块赋值只应用在模型指定的当前场景生效的属性上，其他属性不会被赋值
    public function scenarios() {
        'scenario1' => ['attribute1', 'attribute2'],
        //  属性名加一个惊叹号 ! 表示该属性不是安全属性，但是也会被校验
        //  如 attribute3不会被块赋值，必须显式赋值：$model->attribute3 = 'value';
        'scenario2' => ['attribute1', 'attribute2', '!attribute3'],
    }
    //  定义属性的验证规则
    public function rules() {
        //  on 可用于指定属性生效的场景,如：文件上传与数据查看 属于不同场景
        ['attribute2', 'string', 'on' => 'scenario1'],
        ['attribute2', 'file', 'on' => 'scenario2'],
        //  没有on则在所有场景生效
        //  自定义验证方法，在没有错误的时候，一定要 return true;
        
        //  安全属性,safe验证器申明 哪些属性是安全的不需要被验证
        [['title', 'description'], 'safe'],
        //  description 前加 ！ 表示非安全属性
        [['title1', '!description'], 'string'],
    }
    
    数据导出
    $model->scenario = self::SCENARIO_FIRST;
    $model->toArray([], $expand);   //  $expand指定额外可用字段
    public function fields() {定义的字段是默认字段}
    public function extraFields() {定义额外可用字段}

## 视图 
    /* @var $this yii\web\View */   
    $this 指向 view component 来管理和渲染这个视图文件
    其他变量通过控制器分配
    控制器渲染的视图文件默认放在 @app/[/ModuleDIr/]views/ControllerID 目录下
    对于 小部件 渲染的视图文件默认放在 WidgetPath/views 目录
    
    可覆盖控制器或小部件的 yii\base\ViewContextInterface::getViewPath() 方法来自定义视图文件默认目录。
### 安全
    在显示之前将用户输入数据进行转码和过滤非常重要， 否则，你的应用可能会被 跨站脚本 攻击。
    要显示纯文本，先调用 yii\helpers\Html::encode() 进行转码
        <?= Html::encode($user->name) ?>
    要显示HTML内容，先调用 yii\helpers\HtmlPurifier 过滤内容，但是性能不佳
        <?= HtmlPurifier::process($post->text) ?>
### 渲染视图
    在 控制器 中，可调用以下控制器方法来渲染视图    
    render(): 渲染一个 视图名 并使用一个 布局 返回到渲染结果。
    renderPartial(): 渲染一个 视图名 并且不使用布局。
    renderAjax(): 渲染一个 视图名 并且不使用布局， 并注入所有注册的JS/CSS脚本和文件，通常使用在响应AJAX网页请求的情况下。
    renderFile(): 渲染一个视图文件目录或 别名下的视图文件。
    renderContent(): renders a static string by embedding it into the currently applicable layout.
### 视图名    
    视图名可省略文件扩展名，这种情况下使用 .php 作为扩展
    
    视图名以双斜杠 // 开头，对应的视图文件路径为 @app/views/ViewName，
        例如 //site/about 对应到 @app/views/site/about.php。
    视图名以单斜杠/开始，视图文件路径以当前使用模块 的view path开始， 如果不存在模块，使用@app/views/ViewName开始
        例如，如果当前模块为user， /user/create 对应成 @app/[modules/user/]views/user/create.php
        
    如果 context 渲染视图 并且上下文实现了 yii\base\ViewContextInterface, 视图文件路径由上下文的 view path 开始， 这种主要用在控制器和小部件中渲染视图，
        例如 如果上下文为控制器SiteController，site/about 对应到 @app/views/site/about.php。
        
    如果视图渲染另一个视图，包含另一个视图文件的目录以当前视图的文件路径开始， 
        例如被视图@app/views/post/index.php 渲染的 item 对应到 @app/views/post/item
### 视图中访问数据
    推送：
    推送方式是通过视图渲染方法的第二个参数传递数据， 数据格式应为名称-值的数组， 
    视图渲染时，调用PHP extract() 方法将该数组转换为视图可访问的变量。
    
    拉取：
    可让视图从view component视图组件或其他对象中主动获得数据(如Yii::$app)
        The controller ID is: <?= $this->context->id ?>
        
    视图间共享数据：
    view component视图组件提供params 参数属性来让不同视图共享数据。
        $this->params['breadcrumbs'][] = 'About Us';
## 布局
    layout 可在不同层级（控制器、模块，应用）配置， 被置为 null 或 false 表示不使用布局
    
    布局默认存储在@app/[ModuleDir/]views/layouts路径下,默认 layout = 'main';
    可配置yii\base\Application::$layout 或 yii\base\Controller::$layout 使用其他布局文件
    也可以在 controller下指定 public $layout = '其他布局名称';
    布局的值没有包含文件扩展名，默认使用 .php作为扩展名
### 嵌套布局
    此方法可以多层嵌套
    <?php $this->beginContent('@app/views/layouts/base.php'); ?>
    ...child layout content here...
    <?php $this->endContent(); ?>
    
### 数据块
    首先，在内容视图中定一个或多个数据块
    <?php $this->beginBlock('block1'); ?>
    ...content of block1...
    <?php $this->endBlock(); ?>  
    
    然后，在布局视图中，数据块可用的话会渲染数据块， 如果数据未定义则显示一些默认内容。
    <?php if (isset($this->blocks['block1'])): ?>
        <?= $this->blocks['block1'] ?>
    <?php else: ?>
        ... default content for block1 ...
    <?php endif; ?>
### 注册Meta元标签   yii\web\View::registerMetaTag() 
    元标签通常在布局中生成
    如果想在内容视图中生成元标签，可在内容视图中调用yii\web\View::registerMetaTag()方法， 如下所示：
        <?php
        $this->registerMetaTag(['name' => 'keywords', 'content' => 'yii, framework, php']);
        ?>  
        <meta name="keywords" content="yii, framework, php">
    重复标签只保留最后一个
### 注册链接标签  yii\web\View::registerLinkTag()
    和 Meta标签 类似，链接标签有时很实用，如自定义网站图标，指定Rss订阅，或授权OpenID到其他服务器。
    $this->registerLinkTag([
        'title' => 'Live News for Yii',
        'rel' => 'alternate',
        'type' => 'application/rss+xml',
        'href' => 'http://www.yiiframework.com/rss.xml/',
    ]);
    <link title="Live News for Yii" rel="alternate" type="application/rss+xml" href="http://www.yiiframework.com/rss.xml/">
    重复标签只保留最后一个
### 视图事件    
    View components 视图组件会在视图渲染过程中触发几个事件， 可以在内容发送给终端用户前，响应这些事件来添加内容到视图中或调整渲染结果。
        例如，如下代码将当前日期添加到页面结尾处：
        \Yii::$app->view->on(View::EVENT_END_BODY, function () {
            echo date('Y-m-d');
        });
### 渲染静态页面
    return $this->render('about');
    如果Web站点包含很多静态页面，多次重复相似的代码显得很繁琐， 
    为解决这个问题，可以使用一个在控制器中称为 yii\web\ViewAction 的独立动作。
        例如：
    
        namespace app\controllers;
    
        use yii\web\Controller;
    
        class SiteController extends Controller
        {
            public function actions()
            {
                return [
                    'page' => [
                        'class' => 'yii\web\ViewAction',
                    ],
                ];
            }
        }
        yii2可通过路由规则找到 actionID 对应的 view文件 进行渲染
        
    
        
                         