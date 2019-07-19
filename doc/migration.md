# Migration 数据库迁移

### 常用命令
    //  创建文件
    php yii migrate/create create_table_TABLE_NAME
    php yii migrate/create create_table_TABLE_NAME --
    //  执行迁移
    php yii migrate
    
    //  重新执行最近执行过的迁移
    php yii redo
    php yii redo/3
    
    
### 目录划分
    不同模块的文件放在 appId 对应的目录中
    外键关系统一放在 foreignKey 目录中，方便查看数据表的关系
### 文件命名规则
    不使用全局前缀
    同一个模块的 table_name 使用同样的前缀
    实体表使用名词单数
    关系表使用a_b_relation
    create_table_TABLE_NAME
    add_COLUMNS_to_TABLE_NAME
    drop_COLUMNS_from_TABLE_NAME
    
### 字段命名
    关系表使用联合索引
    实体表使用ID索引或Hash索引
    非主键字段 不需要写 module_name
    逻辑外键 使用 FOREIGN_TABLE_NAME_id
    联合索引 命名 columnA_columnB
    非联合索引 命名 与字段名一致 COLUMN_NAME
    