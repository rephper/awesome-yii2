<?php

use yii\db\Migration;
use common\traits\MigrationOptionsTrait;

/**
 * Class m190717_171857_create_mysql_int_table
 *
 * @property $table
 * @property $option
 */
class m190717_171857_create_mysql_int_table extends Migration
{
    use MigrationOptionsTrait;

    private $table  = '{{%mysql_int}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->db = Yii::$app->mysqlDemo;
        $options = $this->getMysqlOptions('InnoDB');

        $this->createTable(
            $this->table,
            [
                'id'                  => $this->primaryKey()->comment('主键ID'),

                'boolean'             => " BOOLEAN NOT NULL DEFAULT TRUE COMMENT 'boolean类型' ",

                //  1 字节
                'tiny_int'            => " TINYINT NOT NULL DEFAULT 100 COMMENT '有符号TinyInt' ",
                'unsigned_tiny_int'   => " TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '无符号TinyInt' ",

                //  2 字节
                'small_int'           => $this->smallInteger()->notNull()->defaultValue(0)->comment('有符号SmallInt'),
                'unsigned_small_int'  => $this->smallInteger()->unsigned()->notNull()->defaultValue(0)->comment('无符号SmallInt'),

                //  3 字节
                'medium_int'          => " MEDIUMINT NOT NULL DEFAULT 100 COMMENT '有符号MediumInt' ",
                'unsigned_medium_int' => " MEDIUMINT UNSIGNED NOT NULL DEFAULT 100 COMMENT '无符号MediumInt' ",

                //  4 字节
                'int'                 => $this->integer()->notNull()->defaultValue(0)->comment('有符号int'),
                'int3'                => $this->integer()->notNull()->defaultValue(0)->comment('有符号int3'),
                'unsigned_int'        => $this->integer()->notNull()->unsigned()->defaultValue(0)->comment('无符号int'),
                'unsigned_int8'       => $this->integer(8)->notNull()->unsigned()->defaultValue(0)->comment('8位无符号int'),

                //  8 字节
                'big_int'             => $this->bigInteger()->notNull()->defaultValue(0)->comment('有符号BigInt'),
            ],
            $options
        );

        $_type = " INT(8) UNSIGNED ZEROFILL NOT NULL DEFAULT '0' COMMENT '8位无符号int' ";
        $this->alterColumn($this->table, 'unsigned_int8', $_type);

        $_type = $this->bigInteger()->unsigned()->notNull()->defaultValue(0)->comment('无符号BigInt');
        $this->addColumn($this->table, 'unsigned_big_int', $_type);

        $this->addCommentOnTable($this->table, 'MySQL整形数据');

        $this->createIndex('tiny_int', $this->table, 'tiny_int');
        $this->createIndex('unsigned_int8', $this->table, 'unsigned_int8');
        $this->createIndex('int', $this->table, 'int');
        $this->createIndex('big_int', $this->table, 'big_int');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->table);
    }

}
