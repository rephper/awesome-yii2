<?php

use yii\db\Migration;
use common\traits\MigrationOptionsTrait;

/**
 * Handles the creation of table `{{%mysql_float}}`.
 *
 * @property $table
 * @property $option
 */
class m190920_020834_create_mysql_float_table extends Migration
{
    use MigrationOptionsTrait;

    private $table  = '{{%mysql_float}}';

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
                'id' => $this->primaryKey()->comment('主键ID'),
                'float' => $this->float(20, 4)->notNull()->defaultValue(0.0000)->comment('单精度浮点数'),
                'float' => $this->float(20, 4)->notNull()->defaultValue(0.0000)->comment('单精度浮点数'),
            ],
            $options
        );

        $this->addCommentOnTable($this->table, 'MySQL浮点型数据');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%mysql_float}}');
    }
}
