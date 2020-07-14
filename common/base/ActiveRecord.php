<?php

namespace common\base;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\ServerErrorHttpException;

/**
 * Class ActiveRecord
 * @package common\base
 *
 * #======== 成员变量 AR数据字段 ========#
 * @property integer $id
 * @property integer $is_delete
 * @property integer $created_by
 * @property string  $created_at datetime
 * @property integer $updated_by
 * @property string  $updated_at timestamp
 *
 * #======== 成员变量 自定义 ========#
 *
 * #======== 关联关系 ========#
 *
 *
 * #======== 属性加购 ========#
 */
class ActiveRecord extends \yii\db\ActiveRecord
{
    const SCENARIO_SAMPLE = 'sample';

    const IS_TRUE  = true;
    const IS_FALSE = false;

    public static $isMap = [
        self::IS_TRUE  => '是',
        self::IS_FALSE => '否',
    ];

    public $id; //  主键
    public $is_delete;
    public $created_by;
    public $created_at;
    public $updated_by; //
    public $updated_at; //  timestamp

    /**
     * @return array
     */
    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [

            ]
        );
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(
            parent::attributeLabels(),
            [

            ]
        );
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $userId = !empty(Yii::$app->user) && !empty(Yii::$app->user->id) ? Yii::$app->user->id : 0;

            if ($insert && empty($this->created_by)) {
                $this->created_by = $userId;
                $this->created_at = date('Y-m-d H:I:s');
            }

            if (!empty($userId)) {
                $this->updated_by = $userId;
            }

            return true;
        }
        else {
            return false;
        }
    }

    /**
     * 校验入库
     *
     * @return bool
     * @throws BadRequestHttpException
     * @throws ServerErrorHttpException
     */
    public function validateAndSave()
    {
        if (!$this->validate()) {
            throw new BadRequestHttpException('', 1);
        }
        if (!$this->save()) {
            throw new ServerErrorHttpException('', 2);
        }

        return true;
    }

    public function fields()
    {
        switch ($this->scenario) {
            case self::SCENARIO_SAMPLE:
                $data = [
                    'id'           => 'id',
                ];
                break;
            case self::SCENARIO_DEFAULT:
            default:
                $data = parent::fields();
                break;
        }

        return $data;
    }

    /**
     * 获取操作员姓名
     */
    public function getUpdatedBy()
    {

    }

    # public static function find(){ 映射到 ActiveQuery }
}
