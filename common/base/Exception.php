<?php

namespace common\base;

use yii\helpers\VarDumper;
use Yii;

class Exception extends \yii\base\Exception
{
    /**
     * 记录错误日志
     *
     * @param string $title    action标题
     * @param string $category 日志分类
     */
    public function log($title, $category)
    {
        $logData = [
            'title' => $title,
            'code'  => $this->getCode(),
            'msg'   => $this->getMessage(),
            'file'  => $this->getFile(),
            'line'  => $this->getFile(),
            'trace' => $this->getTraceAsString(),
        ];

        Yii::error(VarDumper::dumpAsString($logData), $category);
    }

}
