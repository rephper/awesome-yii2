<?php

use yii\db\Migration;
use common\traits\MigrationOptionsTrait;

/**
 * Handles the creation of table `{{%mysql_datetime}}`.
 */
class m190921_034359_create_mysql_datetime_table extends Migration
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

        $date      = date('Y-m-d');
        $time      = date('H:i:s');
        $year      = date('Y');
        $datetime  = date('Y-m-d H:i:s');

        $this->createTable(
            '{{%mysql_datetime}}',
            [
                'id'         => $this->primaryKey(),
                'date'       => $this->date()->notNull()->defaultValue($date)->comment('日期'),
                'time'       => $this->time()->notNull()->defaultValue($time)->comment('时间'),
                'year'       => " YEAR NOT NULL DEFAULT " . $year . " COMMENT '年份' ",
                'datetime'   => $this->dateTime()->notNull()->defaultValue($datetime)->comment('日期时间'),
                //  timestamp 默认 ->notNull()->defaultValue(0000-00-00 00:00:00),
                'timestamp'  => $this->timestamp()->notNull()->defaultValue($datetime)->comment('时间戳'),
                'updated_at' => " TIMESTAMP NOT NULL on update CURRENT_TIMESTAMP  COMMENT '自动更新字段' ",
            ],
            $options
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%mysql_datetime}}');
    }
}
