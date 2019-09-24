<?php

use yii\db\Migration;
use common\traits\MigrationOptionsTrait;

/**
 * Handles the creation of table `{{%mysql_float}}`.
 *
 * @property $table
 */
class m190920_020834_create_mysql_float_table extends Migration
{
    use MigrationOptionsTrait;

    private $table = '{{%mysql_float}}';

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
                'id'               => $this->primaryKey()->comment('主键ID'),

                //  4 字节float(m, d) m<=24,  7个有效位,最后一位会丢失精度
                'float'            => $this->float(20, 4)->notNull()->defaultValue(0.0000)->comment('有符号单精度'),
                'unsigned_float'   => $this->float(20, 4)->unsigned()->notNull()->defaultValue(0.0000)->comment('无符号单精度'),

                //  8 字节 15个有效位,最后一位会丢失精度
                'double'           => $this->double(32, 4)->notNull()->defaultValue(0.0000)->comment('有符号双精度'),
                'unsigned_double'  => $this->double(32, 4)->unsigned()->notNull()->defaultValue(0.0000)->comment('无符号双精度'),

                //  不存在精度损失，常用于银行帐目计算 28个有效位
                //  DECIMAL(M,D) 默认decimal(10,0) 字节数 MAX(M, D) + 2， M最大为65
                'decimal'          => $this->decimal(10, 2)->notNull()->defaultValue(0.00)->comment('有符号精确值'),
                'unsigned_decimal' => $this->decimal()->unsigned()->notNull()->defaultValue(0.00)->comment('无符号精确值'),
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
