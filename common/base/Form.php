<?php

namespace common\base;

use yii\helpers\VarDumper;
use Yii;

class Form extends Model
{
    const SCENARIO_CONFIG = 'config';
    const SCENARIO_INDEX  = 'index';
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
    const SCENARIO_DETAIL = 'detail';
    const SCENARIO_DELETE = 'delete';
    const SCENARIO_EXPORT = 'export';
    const SCENARIO_IMPORT = 'import';

    /**
     * 统一处理From表单的校验结果
     * @return bool
     */
    public function check()
    {
        if (!$this->validate()) {
            $logData = [
                'scenario'   => $this->scenario,
                'attributes' => $this->attributes,
                'errors'     => $this->errors,
                'userId'     => Yii::$app->user->id,
            ];
            Yii::error(VarDumper::dumpAsString($logData), __METHOD__);

            return false;
        }

        return true;
    }

}
