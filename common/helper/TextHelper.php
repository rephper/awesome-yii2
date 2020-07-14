<?php

namespace common\helper;

class TextHelper
{
    const COLOR_BLACK = '#000000';
    const COLOR_GREEN = '#669933';
    const COLOR_RED   = '#FF0000';
    const COLOR_WHITE = '#FFFFFF';

    const  TEXT_COLOR_DEFAULT     = '#000000';   //  默认
    const  TEXT_COLOR_WAIT_SUBMIT = '#333333';   //  待提审
    const  TEXT_COLOR_NEED_VERIFY = '#FF0000';   //  待审核
    const  TEXT_COLOR_VERIFIED    = '#009900';   //  审核]通过
    const  TEXT_COLOR_REJECT      = '#999999';   //  驳回
    const  TEXT_COLOR_DELETE      = '#999999';   //  作废
    const  TEXT_COLOR_URL         = '#1890FF';   //  可跳链字体
    const  TEXT_COLOR_WARNING     = '#FA8C16';   //  警示字体

    /**
     * 获取模型入库时的错误信息
     * @param $errors
     * @return string
     */
    public static function getErrorsMsg($errors) {
        $msg = '';
        foreach ($errors as $value) {
            foreach ($value as $item) {
                $msg .= $item.',';
            }
        }

        return $msg;
    }
}
