<?php

namespace common\base;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

/**
 * Class Search
 * @package core\base
 *
 * @property string   $keywords
 * @property integer  $currentPage
 * @property integer  $pageSize
 * @property string   $sort
 * @property string   $order
 * @property array    $diyConfig
 * @property string[] $propertyList
 * @property float    $execStart
 * @property float    $execEnd
 */
class Search extends Form
{
    const SCENARIO_CONFIG = 'config';
    const SCENARIO_INDEX  = 'index';
    const SCENARIO_EXPORT = 'export';

    const SORT_ORDER_ASC  = 'asc';
    const SORT_ORDER_DESC = 'desc';

    public $keywords;
    public $currentPage;
    public $pageSize;
    public $sort;
    public $order;
    public $diyConfig;
    public $propertyList;

    private $execStart;
    private $execEnd;

    public function init()
    {
        list($sec, $unix) = explode(' ', microtime());
        $this->execStart = (float)$unix + (float)$sec;
    }

    /**
     * Search类通用参数
     * @return array
     */
    public function rules()
    {
        return [
            ['keywords', 'string'],

            ['currentPage', 'default', 'value' => 1],
            [
                'currentPage',
                'integer',
                'min'     => 1,
                'message' => $this->getAttributeLabel('currentPage') . '最小值为1',
            ],

            ['pageSize', 'default', 'value' => 10],
            [
                'pageSize',
                'integer',
                'min'     => 1,
                'max'     => 1000,
                'message' => $this->getAttributeLabel('pageSize') . ' 范围：1~1000',
            ],

            ['sort', 'string', 'message' => $this->getAttributeLabel('sort') . ' 必须是字符串'],

            ['order', 'string', 'message' => $this->getAttributeLabel('order') . ' 必须是字符串'],
            [
                'order',
                'in',
                'range'   => [self::SORT_ORDER_ASC, self::SORT_ORDER_DESC],
                'message' => $this->getAttributeLabel('order') . ' 无效',
            ],

            [['diyConfig', 'propertyList'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(
            parent::attributeLabels(),
            [
                'keywords'     => '关键词',
                'currentPage'  => '页码',
                'pageSize'     => '分页数',
                'sort'         => '排序列名',
                'order'        => '排序规则',
                'diyConfig'    => '自定义表格',
                'propertyList' => '返回的属性列表',
            ]
        );
    }

    /**
     * 记录查询的执行耗时
     *
     * @param ActiveQuery $query
     * @param string      $category
     */
    private function execTimeLog($query, $category)
    {
        list($sec, $unix) = explode(' ', microtime());
        $this->execEnd = (float)$unix + (float)$sec;

        $logData = [
            'title'     => 'Search exec time',
            'sql'       => $query->createCommand()->rawSql,
            'execStart' => $this->execStart,
            'execEnd'   => $this->execEnd,
            'execTime'  => $this->execEnd - $this->execStart,
        ];

        Yii::warning(VarDumper::dumpAsString($logData), $category);
    }

}
