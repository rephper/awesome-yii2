<?php

namespace common\helper;

use common\base\Model;
use Yii;

/**
 * Class LogHelper
 * @package core\helper
 *
 * @property string $title
 * @property array  $data
 * @property string $sql
 */
class LogHelper extends Model
{
    const SCENARIO_SQL    = 'SQL';
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
    const SCENARIO_DELETE = 'delete';

    public $title;
    public $data;
    public $sql;

    public function rules()
    {
        return [
            [
                ['title', 'data', 'category', 'method'],
                'required',
                'on' => [
                    self::SCENARIO_SQL,
                    self::SCENARIO_CREATE,
                    self::SCENARIO_UPDATE,
                    self::SCENARIO_DELETE,
                    self::SCENARIO_DEFAULT,
                ],
            ],

            [
                ['title', 'category', 'method'],
                'string',
                'on' => [
                    self::SCENARIO_SQL,
                    self::SCENARIO_CREATE,
                    self::SCENARIO_UPDATE,
                    self::SCENARIO_DELETE,
                    self::SCENARIO_DEFAULT,
                ],
            ],

            [
                'data',
                'checkIsArray',
                'on' => [
                    self::SCENARIO_SQL,
                    self::SCENARIO_CREATE,
                    self::SCENARIO_UPDATE,
                    self::SCENARIO_DELETE,
                    self::SCENARIO_DEFAULT,
                ],
            ],

            [
                'sql',
                'required',
                'on' => [
                    self::SCENARIO_SQL,
                ],
            ],
        ];
    }

    public function checkIsArray()
    {
        if (!is_array($this->data)) {
            $this->addError('data', '日志数据必须是数组格式');
        }

        return true;
    }

    /**
     * 格式化日志数据，校验日志完整性
     *
     * @return array
     */
    public function formatLog()
    {
        $logData = $this->data;
        array_unshift($log, ['title' => $this->title]);

        switch ($this->scenario) {
            case self::SCENARIO_SQL:
                if (isset($this->sql)) {
                    $logData['SQL'] = $this->sql;
                }

            case self::SCENARIO_DEFAULT:
            default:
                break;
        }

        return $logData;
    }

}
