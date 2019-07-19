<?php

use yii\db\Migration;

/**
 * Class m190717_171857_create_table_mysql_int
 *
 * @property $table
 * @property $option
 */
class m190717_171857_create_table_mysql_int extends Migration
{
    private $table = 'mysql_int';
    private $option = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTabe(
            $this->table,
            [
                'id' => $this->primaryKey()->comment('主键ID'),
                'int' => $this->integer()->notNull()->defaultValue(0)->comment('有符号整型'),
                'unsigned_int' => $this->integer()->notNull()->unsigned()->defaultValue(0)->comment('无符号整型'),
                'small_int' => $this->smallInteger()->notNull()->defaultValue(0)->comment('短整型'),
                'tiny_int' => " TINY INT NOT NULL UNSIGNED DEFAULT 100 COMMENT '整型'",
                'big_int' => $this->bigInteger()->notNull()->defaultValue(0)->comment('长整型'),
            ],
            $this->option
        );
        
        $this->createIndex('int', $this->table, 'int');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->table);
    }

}
