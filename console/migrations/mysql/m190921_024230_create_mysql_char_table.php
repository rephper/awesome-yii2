<?php

use yii\db\Migration;
use common\traits\MigrationOptionsTrait;

/**
 * Handles the creation of table `{{%mysql_char}}`.
 */
class m190921_024230_create_mysql_char_table extends Migration
{
    use MigrationOptionsTrait;

    public function __construct(array $config = [])
    {
        parent::__construct($config);
        $this->db = Yii::$app->mysqlDemo;
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $options  = $this->getMysqlOptions('MyISAM');

        $this->createTable(
            '{{%mysql_char}}',
            [
                'id'         => $this->primaryKey(),

                //  char 最大长度255
                'char'       => $this->string(20)->notNull()->defaultValue('')->comment('定长字符串'),
                //  varchar 最大长度65535
                'varchar'    => $this->string(32)->notNull()->comment('变长字符串'),

                //  二进制字符串 binary默认长度1
                'binary'     => " BINARY(20) NOT NULL DEFAULT '' COMMENT '二进制定长字符串' ",
                'varbinary'  => " VARBINARY(140) NOT NULL DEFAULT '' COMMENT '二进制变长字符串' ",

                //  最大长度65535 text 类型不支持 设置default
                'text'       => $this->text()->notNull()->defaultValue('')->comment('变长text'),
                //  最大长度255
                'tinytext'   => " TINYTEXT NOT NULL DEFAULT '' COMMENT '变长tinyText' ",
                //  最大长度 2的24次方-1个字符
                'mediumtext' => " MEDIUMTEXT NOT NULL DEFAULT '' COMMENT '变长mediumText' ",
                //  最大长度 2的32次方-1个字符
                'longtext'   => " LONGTEXT NOT NULL DEFAULT '' COMMENT '变长longText' ",

                //  BLOB
                'blob'       => $this->binary()->notNull()->defaultValue('')->comment('二进制长文本blob'),
                'tinyblob'   => " TINYBLOB NOT NULL DEFAULT '' COMMENT '二进制长文本tinyBlob' ",
                'mediumblob' => " MEDIUMBLOB NOT NULL DEFAULT '' COMMENT '二进制长文本mediumBlob' ",
                'longblob'   => " LONGBLOB NOT NULL DEFAULT '' COMMENT '二进制长文本longBlob' ",
            ],
            $options
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%mysql_char}}');
    }
}
