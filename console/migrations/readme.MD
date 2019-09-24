# Migration
    php yii migrate/相关命令 --migrationPath=console/migrations/DIR_ANME
## 数据库迁移脚本目录划分
    默认每个目录对应一个功能模块的所有migration
    
    例外：
    foreign-key 添加/删除 外键，只用于产看表间关系，业务使用逻辑外键
    feed 添加基础数据用于测试、体验
    
    按功能模块名称