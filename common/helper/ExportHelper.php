<?php

namespace common\helper;

use yii\web\Response;
use Yii;

class ExportHelper
{
    const FILE_TYPE_EXCEL = 'excel';
    const FILE_TYPE_WORD  = 'word';
    const FILE_TYPE_ZIP   = 'zip';

    /**
     * 设置导出文件类型的 headers
     *
     * @param $fileType
     */
    public static function setHeaders($fileType)
    {
        switch ($fileType) {
            case self::FILE_TYPE_EXCEL:
                Yii::$app->response->format = Response::FORMAT_RAW;
                Yii::$app->response->headers->set('Content-Type', 'application/msexcel');
                Yii::$app->response->headers->set('Access-Control-Expose-Headers', 'Content-Disposition');
                break;

            default:
                break;
        }
    }

}
