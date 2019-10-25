<?php

namespace frontend\models\mysql;

use Yii;

/**
 * This is the model class for table "mysql_int".
 *
 * @property int    $id                  主键ID
 * @property int    $boolean             boolean类型
 * @property int    $tiny_int            有符号TinyInt
 * @property int    $unsigned_tiny_int   无符号TinyInt
 * @property int    $small_int           有符号SmallInt
 * @property int    $unsigned_small_int  无符号SmallInt
 * @property int    $medium_int          有符号MediumInt
 * @property string $unsigned_medium_int 无符号MediumInt
 * @property int    $int                 有符号int
 * @property int    $int3                有符号int3
 * @property string $unsigned_int        无符号int
 * @property string $unsigned_int8       8位无符号int
 * @property string $big_int             有符号BigInt
 * @property string $unsigned_big_int    无符号BigInt
 */
class MysqlInt extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mysql_int';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('mysqlDemo');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [
                    'boolean',
                    'tiny_int',
                    'unsigned_tiny_int',
                    'small_int',
                    'unsigned_small_int',
                    'medium_int',
                    'unsigned_medium_int',
                    'int',
                    'int3',
                    'unsigned_int',
                    'unsigned_int8',
                    'big_int',
                    'unsigned_big_int'
                ],
                'integer'
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'                  => '主键ID',
            'boolean'             => 'boolean类型',
            'tiny_int'            => '有符号TinyInt',
            'unsigned_tiny_int'   => '无符号TinyInt',
            'small_int'           => '有符号SmallInt',
            'unsigned_small_int'  => '无符号SmallInt',
            'medium_int'          => '有符号MediumInt',
            'unsigned_medium_int' => '无符号MediumInt',
            'int'                 => '有符号int',
            'int3'                => '有符号int3',
            'unsigned_int'        => '无符号int',
            'unsigned_int8'       => '8位无符号int',
            'big_int'             => '有符号BigInt',
            'unsigned_big_int'    => '无符号BigInt',
        ];
    }

    /**
     * {@inheritdoc}
     * @return MysqlIntQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MysqlIntQuery(get_called_class());
    }
}
