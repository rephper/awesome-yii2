https://www.phpcomposer.com/
------------------------------------------------

# 修改镜像
## 使用国内镜像
  修改 composer 的全局配置文件
  composer config -g repo.packagist composer https://packagist.phpcomposer.com
  
## 解除镜像并恢复到 packagist 官方源  
  composer config -g --unset repos.packagist
  
# 常用命令
  php composer.phar install
  //  全部更新
  php composer.phar update  
  //  指定更新——全路径
  php composer.phar update vendor/package vendor/package2
  //  指定更新——通配符
  php composer.phar update vendor/*
  //  查找依赖包
  php composer.phar search monolog
  //  列出所有可用的软件包
  php composer.phar show
  //  自我更新
  php composer.phar self-update
  //  自我更新指定版本
  php composer.phar self-update 1.0.0-alpha7
  
  //  创建项目
  php composer.phar create-project doctrine/orm path 2.2.*
  //  归档
  php composer.phar archive vendor/package 2.0.21 --format=zip
  //  获取帮助信息
  php composer.phar help install
