<?php

use yii\db\Migration;
use common\traits\MigrationOptionsTrait;

/**
 * Handles the creation of table `{{%mysql_bit}}`.
 *
 * @property string $table
 */
class m190920_103012_create_mysql_bit_table extends Migration
{
    use MigrationOptionsTrait;

    private $table = '{{%mysql_bit}}';

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
            $this->table,
            [
                'id'    => $this->primaryKey(),
                //  位类型，默认1 最大64
                'bit1'  => " BIT NOT NULL DEFAULT 0 COMMENT '1bit' ",
                'bit8'  => " BIT(8) NOT NULL DEFAULT 0 COMMENT '8bit' ",
                'bit64' => " BIT(64) NOT NULL DEFAULT 0 COMMENT '8bit' ",
            ],
            $options
        );

        $this->addCommentOnTable($this->table, 'mysql位类型');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->table);
    }
}
