<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
   Yii 2 Advanced Project Template Code Demo
</p>

Documentation is at [docs/guide/README.md](docs/guide/README.md).
[![Latest Stable Version](https://img.shields.io/packagist/v/yiisoft/yii2-app-advanced.svg)](https://packagist.org/packages/yiisoft/yii2-app-advanced)
[![Total Downloads](https://img.shields.io/packagist/dt/yiisoft/yii2-app-advanced.svg)](https://packagist.org/packages/yiisoft/yii2-app-advanced)
[![Build Status](https://travis-ci.org/yiisoft/yii2-app-advanced.svg?branch=master)](https://travis-ci.org/yiisoft/yii2-app-advanced)

# 目录结构 DIRECTORY STRUCTURE
-------------------

```
common                   公共代码，model定义，组件配置  
console                  数据库迁移，自定义脚本
environments/            不同环境的配置文件，使用 php init 指定环境，替换配置文件

vendor/                  项目依赖的第三方包

doc                      文档、知识点总结
holly-bible              工具书

[APP_NAME]
    assets/              前端资源 JS CSS 等
    config/              当前APP的配置项
    controllers/         Web controller
    models/              APP专用model 或 extends common/models/XxxModel
    runtime/             运行时文件，日志、调试信息等
    tests/               测试代码
    views/               视图文件
    web/                 入口脚本，运行时前端资源
    widgets/             视图挂件

```

# 应用划分
    [ ]  API         RESTFul风格的API
    [*]  Backend     后台管理
    [ ]  COMMON      通用代码
    [ ]  Console     脚本命令
    [*]  Doc         文档
    [ ]  ERP         多个module的应用，包含但不限于 进销存数据流、oa工作流、通知信息流、报表
    [*]  Frontend    前台网站、单店铺商城系统
    [ ]  GIT         GIT工具的使用
    [ ]  HollyBible  工具书
    [ ]  Infomation  类CMS的知识库
    [ ]  JustForFine 做一个有趣的人
    [ ]  Keep        日程记录
    [ ]  Log         日志系统
    [ ]  MindManager 思维导图、图形工具
    [ ]  Notice      通知系统，站内信、邮件、短信
    [ ]  Open        开放平台,通用接口
    [ ]  Project     项目管理工具
    [ ]  Q&A         问卷调查
    [ ]  Resource    资源管理：图片、视频、音频、下载
    [ ]  Search      搜索引擎，Sphinx高效、Xunsearch支持中文拼音，易用
    [ ]  Test        测试用例
    [ ]  UserCenter  用户中心，单点登录
    [ ]  View        视图、组件
    [ ]  WebService  服务
    [ ]  X           弥补PHP的短板，Swoole框架、Docker、workerman
    [ ]  Yes_whY     是什么&为什么          
    [ ]  Zend        官方

## PS:状态说明
    [ ] 未开始
    [*] 进行中
    [=] 暂停
    [√] 已完成
    [±] 修补