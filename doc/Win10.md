# Win10Pro 
## 系统安装
    镜像文件：https://www.microsoft.com/zh-cn/software-download/windows10
    安装工具：https://cn.ultraiso.net/uiso9_cn.exe  UltraISO软碟通
    磁盘分区：https://www.iplaysoft.com/tools/partition-calculator/
        Windows 10 自动创建的隐藏分区大小列表(566M)
        恢复分区    系统分区    MSR (保留)
        450 MB      100 MB      16 MB
        
        NTFS 整数G分区对应关系  
        128G    131078 MB
        80G	    81926 MB
        64G     65539 MB
        32G     32774 MB
        
    桌面及个人文档存放目录迁移到非系统盘——右键——>位置 
    系统激活
    更新
    
    启动开发者选项
    【控制面板】启用 适用于Linux系统的Windows子系统
## 基础软件
    Chrome      https://www.google.cn/chrome/index.html
    Bandizip    http://www.bandisoft.com/bandizip/
    Listary     https://www.listary.com/download
    PDF         https://acrobat.adobe.com/cn/zh-Hans/acrobat/pdf-reader.html
    搜狗输入法   https://pinyin.sogou.com/
    微信        https://pinyin.sogou.com/
    QQ影音      https://player.qq.com/
    Office2016全家桶
## 应用市场
    Microsoft To-Do
    Ubuntun18.04LTS       

## PHP开发环境
### Xampp  https://www.apachefriends.org/zh_cn/index.html
    PHP环境变量配置：【此电脑】右键——>属性——>高级系统设置——>环境变量——>PATH
    
    MySQL修改密码
         关闭正在运行的MySQL服务
         DOS模式下     mysql\bin目录 
            mysqld --skip-grant-tables
         一个DOS窗口   mysql\bin目录
            mysql回车
            use mysql; 
            update user set password=password("root") where user="root";
            flush privileges;
            quit
    
    phpMyAdmin记住密码
        xampp_PATH\phpMyAdmin目录
        找到config.sample.inc.php复制一份文件名改为config.inc.php
        
        $cfg['Servers'][$i]['auth_type'] = 'cookie';
        改成
        $cfg['Servers'][$i]['auth_type'] = 'config';
        $cfg['Servers'][$i]['user']      = 'root';
        $cfg['Servers'][$i]['password']  = 'root';
        
        这里$i对应一个mysql服务器
        $cfg['Servers'][$i]['host'] = '127.0.0.1';
    
    修改Apache配置  xampp_PATH\apache\conf\httpd.conf
        开启 LoadModule vhost_alias_module modules/mod_vhost_alias.so
        开启 Include conf/extra/httpd-vhosts.conf
        在文件底部添加如下代码：
            <Directory "D:/www"> 
                 Options FollowSymLinks IncludesNOEXEC Indexes
                 DirectoryIndex index.html index.htm index.php
                 AllowOverride all 
                 Order Deny,Allow 
                 Allow from all 
                 Require all granted
            </Directory>
            
    配置虚拟主机 xampp_PATH\apache\conf\extra\httpd-vhosts.conf 
        <VirtualHost *:80>
            DocumentRoot "D:/www/APP_PATH"
            ServerName local.dev.com
        </VirtualHost>
            
### Git命令行工具        https://git-scm.com/
    支持第三方软件调用
    Looks-Theme flat-ui
    Text        Console 12pt
    
### GitKraken           https://release.gitkraken.com/win64/GitKrakenSetup.exe

### PHPStorm            https://www.jetbrains.com/phpstorm/

### SwitchHosts!        https://oldj.github.io/SwitchHosts/
    Win+R 输入 drivers 回车
    修改 ./etc/hosts 文件操作权限 
### Xdebug              
    php -i > 要写入的目标文件
    复制phpinfo 内容到 https://xdebug.org/wizard.php 提交
    根据提示 下载dll文件到 xampp_PATH\php\ext
    编辑 xampp_PATH\php\php.ini 文件，在底部追加：
    zend_extension = xampp_PATH\php\ext\php_xdebug-VERSION.dll
    
    在 php.ini 配置文件中添加 xdebug 的配置项：
        [XDebug]
        xdebug.remote_enable = 1
        xdebug.remote_autostart = 1
        
    打开phpStorm,快捷键Clt+Alt+S打开settings搜索Xdebug
    进入Settings>PHP>Debug>DBGp Proxy，
        IDE key 填 PHPSTORM，host 填localhost，port填9000
    进入Settings>PHP>Servers，这里要填写服务器端的相关信息，
        如：name填localhost，host填localhost，port填80，debugger选XDebug
    .进入Run> Edit Configurations...，
        点default，选择PHP Web Application，
        Server选填localhost，
        Start URL填你要访问的目录或者页面（如：/index.php）， 
        Browser 默认或者选chrome    
        
    
### Fiddler             https://www.telerik.com/fiddler
### Postman             https://www.getpostman.com/
### Developer FireFox   https://www.mozilla.org/zh-CN/firefox/developer/

    
    