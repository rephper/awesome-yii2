<?php

namespace common\base;


/**
 * Class ActiveQuery
 * @package core\base
 * 本类除了 all() one() 返回对象， 其他方法 统一 返回 query 便于SQL条件的复用
 *
 * @property string $aliasName
 */
abstract class ActiveQuery extends \yii\db\ActiveQuery
{
    protected $aliasName = '';

    /**
     * 分页取数据
     *
     * @param integer $currentPage
     * @param integer $pageSize
     *
     * @return ActiveQuery
     */
    public function take($currentPage, $pageSize)
    {
        $offset = ($currentPage - 1) * $pageSize;

        return $this->offset($offset)
            ->limit($pageSize);
    }

    /**
     * 筛选列
     * @param array $columns
     *
     * @return ActiveQuery
     */
    public function addSelectColumns(array $columns)
    {
        $array = [];
        foreach ($columns as $column) {
            $array[] = $this->aliasName . '.' . $column;
        }
        return $this->addSelect($array);
    }

    /**
     * 排序规则
     * @param array $config
     *
     * @return ActiveQuery
     */
    public function addOrderByList(array $config)
    {
        $orderArray = [];
        foreach ($config as $sort => $order) {
            $orderArray[] = [$this->aliasName . '.' . $sort => $order];
        }
        return $this->addSelect($orderArray);
    }

    /**
     * @inheritdoc
     * @return Goods[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Goods|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

}
