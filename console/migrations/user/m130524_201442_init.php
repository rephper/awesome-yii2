<?php

use yii\db\Migration;
use common\traits\MigrationOptionsTrait;

class m130524_201442_init extends Migration
{
    use MigrationOptionsTrait;

    public function up()
    {
        //  默认创建表到主库中
//        $this->db = Yii::$app->db;

        $options = $this->getMysqlOptions('InnoDB');

        $this->createTable(
            '{{%user}}',
            [
                'id'                   => $this->primaryKey(),
                'username'             => $this->string()->notNull()->unique(),
                'auth_key'             => $this->string(32)->notNull(),
                'password_hash'        => $this->string()->notNull(),
                'password_reset_token' => $this->string()->unique(),
                'email'                => $this->string()->notNull()->unique(),

                'status'     => $this->smallInteger()->notNull()->defaultValue(10),
                'created_at' => $this->integer()->notNull(),
                'updated_at' => $this->integer()->notNull(),
            ],
            $options
        );

        $this->addCommentOnTable('{{%user}}', '用户表');
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
