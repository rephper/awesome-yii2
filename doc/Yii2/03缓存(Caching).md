# 缓存组件
    'components' => [
        'cache' => [
            'class' => '缓存存储区名称',
        ]
    ]
## 支持的缓存存储器
    yii\caching\ApcCache：使用 PHP APC 扩展。 这个选项可以认为是集中式应用程序环境中 （例如：单一服务器，没有独立的负载均衡器等）最快的缓存方案。
    yii\caching\DbCache：使用一个数据库的表存储缓存数据。要使用这个缓存， 你必须创建一个与 yii\caching\DbCache::$cacheTable 对应的表。
    yii\caching\ArrayCache: 仅通过将值存储在数组中来为当前请求提供缓存。 为了增强 ArrayCache 的性能，您可以通过将 yii\caching\ArrayCache::$serializer 设置为 false 来禁用已存储数据的序列化。
    yii\caching\DummyCache：仅作为一个缓存占位符，不实现任何真正的缓存功能。 这个组件的目的是为了简化那些需要查询缓存有效性的代码。例如， 在开发中如果服务器没有实际的缓存支持，用它配置一个缓存组件。 一个真正的缓存服务启用后，可以再切换为使用相应的缓存组件。 两种条件下你都可以使用同样的代码 Yii::$app->cache->get($key) 尝试从缓存中取回数据而不用担心 Yii::$app->cache 可能是 null。
    yii\caching\FileCache：使用标准文件存储缓存数据。 这个特别适用于缓存大块数据，例如一个整页的内容。
    yii\caching\MemCache：使用 PHP memcache 和 memcached 扩展。 这个选项被看作分布式应用环境中（例如：多台服务器，有负载均衡等） 最快的缓存方案。
    yii\redis\Cache：实现了一个基于 Redis 键值对存储器的缓存组件 （需要 redis 2.6.12 及以上版本的支持 ）。
    yii\caching\WinCache：使用 PHP WinCache （另可参考）扩展.
    yii\caching\XCache：使用 PHP XCache扩展。
    yii\caching\ZendDataCache：使用 [Zend Data Cache](http://files.zend.com/help/Zend-Server-6/zend- server.htm#data_cache_component.htm) 作为底层缓存媒介。

## 缓存API
    所有缓存组件都有同样的基类 yii\caching\Cache ，因此都支持如下 API
        get()：通过一个指定的键（key）从缓存中取回一项数据。 如果该项数据不存在于缓存中或者已经过期/失效，则返回值 false。
        set()：将一个由键指定的数据项存放到缓存中。
        add()：如果缓存中未找到该键，则将指定数据存放到缓存中。
        getOrSet()：返回由键指定的缓存项，或者执行回调函数，把函数的返回值用键来关联存储到缓存中， 最后返回这个函数的返回值。
        multiGet()：由指定的键获取多个缓存数据项。
        multiSet()：一次存储多个数据项到缓存中，每个数据都由一个键来指明。
        multiAdd()：一次存储多个数据项到缓存中，每个数据都由一个键来指明。 如果某个键已经存在，则略过该数据项不缓存。
        exists()：返回一个值，指明某个键是否存在于缓存中。
        delete()：通过一个键，删除缓存中对应的值。
        flush()：删除缓存中的所有数据。

## 提示
    你可以在同一个应用程序中使用不同的缓存存储器。一个常见的策略是:
    使用基于内存的缓存存储器 存储小而常用的数据（例如：统计数据），
    使用基于文件或数据库的缓存存储器 存储大而不太常用的数据（例如：网页内容）。

# 数据缓存
    keyPrefix 当同一个缓存存储器被用于多个不同的应用时，应该为每个应用指定一个唯一的缓存键前缀以避免缓存键冲突。
        'components' => [
            'cache' => [
                'class' => 'yii\caching\ApcCache',
                'keyPrefix' => 'myapp',       // 唯一键前缀，为了确保互通性，此处只能使用字母和数字。
            ],
        ],
    数据缓存是指将一些 PHP 变量存储到缓存中，使用时再从缓存中取回。
    它也是更高级缓存特性的基础，例如查询缓存 和内容缓存。
    Yii::$app->cache->set($key, $value);
    Yii::$app->cache->get($key);
    Yii::$app->cache->getOrSet($key, 闭包函数);
    Yii::$app->cache->set($key, $data, 45);
    从 2.0.11 开始，可以在缓存组件配置中设置 defaultDuration 成员属性的值——定义缓存的持续时间
    这样设置会覆盖默认的缓存持续时间，且在使用 set() 方法时不必每次都传递 $duration 参数。

    注意： 通过 multiSet() 或者 multiAdd() 方法缓存的数据项的键，它的类型只能是字符串或整型，
    如果你想使用较为复杂的键，可以通过 set() 或者 add() 方法来存储。

## 缓存依赖
    除了超时设置，缓存数据还可能受到缓存依赖的影响而失效。
        例如，yii\caching\FileDependency 代表对一个文件修改时间的依赖。
        缓存中任何过期的文件内容都应该被置为失效状态， 对 get() 的调用都应该返回 false。
        //  创建一个文件缓存，30秒后超时，如果30秒内文件被修改，则缓存失效
        $dependency = new \yii\caching\FileDependency(['fileName' => 'example.txt']);
        $cache->set($key, $data, 30, $dependency);
    注意： 避免对带有缓存依赖的缓存项使用 exists() 方法，
          因为它不检测缓存依赖（如果有的话）是否有效，所以调用 get() 可能返回 false 而调用 exists() 却返回 true。
##下面是可用的缓存依赖的概况：
    yii\caching\ChainedDependency：如果依赖链上任何一个依赖产生变化，则依赖改变。
    yii\caching\DbDependency：如果指定 SQL 语句的查询结果发生了变化，则依赖改变。
    yii\caching\ExpressionDependency：如果指定的 PHP 表达式执行结果发生变化，则依赖改变。
    yii\caching\FileDependency：如果文件的最后修改时间发生变化，则依赖改变。
    yii\caching\TagDependency：将缓存的数据项与一个或多个标签相关联。
    您可以通过调用  yii\caching\TagDependency::invalidate() 来检查指定标签的缓存数据项是否有效。

## 查询缓存
    查询缓存是一个建立在数据缓存之上的特殊缓存特性。 它用于缓存数据库查询的结果。
        $result = $db->cache(function ($db) {
            // 如果启用查询缓存并且在缓存中找到查询结果
            return $db->createCommand('SELECT * FROM customer WHERE id=1')->queryOne();
        });
    查询缓存可以用在DAO和ActiveRecord上:
        $result = Customer::getDb()->cache(function ($db) {
            return Customer::find()->where(['id' => 1])->one();
        });
        自 2.0.14 以后，您可以使用以下快捷方法：User::find()->cache(缓存时间的秒数)->all();
    有时在cache()里，你可能不想缓存某些特殊的查询， 这时你可以用yii\db\Connection::noCache()。
        $result = $db->cache(function ($db) {
            // 使用查询缓存的 SQL 查询
            $db->noCache(function ($db) {
                // 不使用查询缓存的 SQL 查询
            });
            return $result;
        });
## 限制条件
    当查询结果中含有资源句柄时，查询缓存无法使用。
        例如，在有些 DBMS 中使用了 BLOB 列的时候， 缓存结果会为该数据列返回一个资源句柄。
    有些缓存存储器有大小限制。
        例如，memcache 限制每条数据最大为 1MB。
        因此，如果查询结果的大小超出了该限制， 则会导致缓存失败。
## 缓存冲刷
    可以调用 yii\caching\Cache::flush()
    也还可以从控制台调用 yii cache/flush。
        yii cache：列出应用中可用的缓存组件
        yii cache/flush cache1 cache2：刷新缓存组件cache1，cache2 (可以传递多个用空格分开的缓存组件）
        yii cache/flush-all：刷新应用中所有的缓存组件
        yii cache/flush-schema db：清除给定连接组件的数据库表结构缓存

        默认情况下，控制台应用使用独立的配置文件。
        所以，为了上述命令发挥作用，请确保 Web 应用和控制台应用配置相同的缓存组件

# 片段缓存
    片段缓存指的是缓存页面内容中的某个片段。
    在视图中使用以下结构启用片段缓存：
        if ($this->beginCache($id)) {
            // ... 在此生成内容 ...
            $this->endCache();
        }
        如果缓存中存在该内容，beginCache() 方法将渲染内容并返回 false， 因此将跳过内容生成逻辑。
        否则，内容生成逻辑被执行， 一直执行到endCache() 时， 生成的内容将被捕获并存储在缓存中。

## 缓存选项
    通过向 beginCache() 方法第二个参数传递配置数组。
    在框架内部，该数组将被用来配置一个 yii\widget\FragmentCache 小部件用以实现片段缓存功能。

    duration    过期时间
    dependency  缓存依赖
    variations  变量参数，如不同语言对应不同的缓存结果
    enabled     在特定条件下开启片段缓存
## 缓存嵌套
    片段缓存可以被嵌套使用。一个片段缓存可以被另一个包裹。
    外层的失效时间应该短于内层，外层的依赖条件应该低于内层，以确保最小的片段，返回的是最新的数据。

## 动态内容
    在缓存片段中有部分数据不应被缓存，为了使内容保持动态，每次请求都执行PHP代码生成，即使这些代码已经被缓存了。
    $this->renderDynamic('return Yii::$app->user->identity->name;');
    renderDynamic() 方法接受一段 PHP 代码作为参数。

# 页面缓存
    页面缓存由 yii\filters\PageCache 类提供支持，该类是一个过滤器。
    在 behaviors 里使用

    页面缓存和片段缓存极其相似。 它们都支持 duration，dependencies，variations 和 enabled 配置选项。
    它们的主要区别是页面缓存是由过滤器实现，而片段缓存则是一个小部件。

    你可以在使用页面缓存的同时， 使用片段缓存和动态内容。

# HTTP 缓存
    Last-Modified 头使用时间戳标明页面自上次客户端缓存后是否被修改过。
    通过配置 yii\filters\HttpCache::$lastModified 属性向客户端发送 Last-Modified 头。
    该属性的值应该为 PHP callable 类型，返回的是页面修改时的 Unix 时间戳。
        public function behaviors()
        {
            return [
                [
                    'class' => 'yii\filters\HttpCache',
                    'only' => ['index'],
                    'lastModified' => function ($action, $params) {
                        $q = new \yii\db\Query();
                        return $q->from('post')->max('updated_at');
                    },
                ],
            ];
        }

    ETag 头
    “Entity Tag”（实体标签，简称 ETag）使用一个哈希值表示页面内容。
    如果页面被修改过， 哈希值也会随之改变。浏览器就能判断页面是否被修改过，进而决定是否应该重新传输内容。
        public function behaviors()
        {
            return [
                [
                    'class' => 'yii\filters\HttpCache',
                    'only' => ['view'],
                    'etagSeed' => function ($action, $params) {
                        $post = $this->findModel(\Yii::$app->request->get('id'));
                        return serialize([$post->title, $post->content]);
                    },
                ],
            ];
        }
    ETag 相比 Last-Modified 能实现更复杂和更精确的缓存策略。
    复杂的 Etag 生成种子可能会违背使用 HttpCache 的初衷而引起不必要的性能开销， 因为响应每一次请求都需要重新计算 Etag。
    请试着找出一个最简单的表达式去触发 Etag 失效。

    Cache-Control 头指定了页面的常规缓存策略。
    可以通过配置 yii\filters\HttpCache::$cacheControlHeader 属性发送相应的头信息。默认发送以下头：
        Cache-Control: public, max-age=3600

