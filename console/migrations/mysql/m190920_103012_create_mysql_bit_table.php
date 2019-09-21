<?php

use yii\db\Migration;
use common\traits\MigrationOptionsTrait;

/**
 * Handles the creation of table `{{%mysql_bit}}`.
 */
class m190920_103012_create_mysql_bit_table extends Migration
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
        $options  = $this->getMysqlOptions('InnoDB');

        $this->createTable(
            '{{%mysql_bit}}',
            [
                'id'    => $this->primaryKey(),
                //  位类型，默认1 最大64
                'bit1'  => " BIT NOT NULL DEFAULT 0 COMMENT '1bit' ",
                'bit8'  => " BIT(8) NOT NULL DEFAULT 0 COMMENT '8bit' ",
                'bit64' => " BIT(64) NOT NULL DEFAULT 0 COMMENT '8bit' ",
            ],
            $options
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%mysql_bit}}');
    }
}
