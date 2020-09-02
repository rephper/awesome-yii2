# 推荐使用的Apache配置
  # 设置文档根目录为 "basic/web"
  DocumentRoot "path/to/basic/web"

  <Directory "path/to/basic/web">
      # 开启 mod_rewrite 用于美化 URL 功能的支持（译注：对应 pretty URL 选项）
      RewriteEngine on
      # 如果请求的是真实存在的文件或目录，直接访问
      RewriteCond %{REQUEST_FILENAME} !-f
      RewriteCond %{REQUEST_FILENAME} !-d
      # 如果请求的不是真实文件或目录，分发请求至 index.php
      RewriteRule . index.php

      # if $showScriptName is false in UrlManager, do not allow accessing URLs with script name
      RewriteRule ^index.php/ - [L,R=404]
    
      # ...其它设置...
  </Directory>



## 多域名配置

### 	apache/conf/httpd.conf 文件 开启 Include conf/extra/httpd-vhosts.conf 支持

### 	apacheconf/extra/httpd-vhosts.conf 配置 项目目录权限、目录映射

### 目录权限

​	`<Directory "C:/alidata/www">

  		Options Indexes FollowSymLinks Includes ExecCGI

  		AllowOverride All

  		Order allow,deny

  		Allow from all

​	</Directory>`

#### 目录映射

​	`<VirtualHost *:80>

  		DocumentRoot "C:/alidata/www/xiaomei360.com/backend/web"

  		ServerName t102.backend.xiaomei360.com

 		 ErrorLog "logs/backend.xiaomei360.com.com-error.log"

  		CustomLog "logs/backend.xiaomei360.com-access.log" common

​	</VirtualHost>`