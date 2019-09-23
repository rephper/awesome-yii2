<?php
namespace frontend\components\action;

use yii\base\Action;

/**
 * 独立动作
 * Class HelloWorldAction
 * @package frontend\components\action
 */
class HelloWorldAction extends Action
{
    /**
     * 操作方法或独立操作的run()方法的返回值非常重要， 它表示对应操作结果。
     * 返回值可为 响应 对象，作为响应发送给终端用户。
     * 对于Web applications网页应用，返回值可为任意数据, 它赋值给yii\web\Response::$data， 最终转换为字符串来展示响应内容。
     * 对于console applications控制台应用，返回值可为整数， 表示命令行下执行的 exit status 退出状态。
     * @return string
     */
    public function run()
    {
        return "Hello World";
    }
}
