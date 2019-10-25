<?php

namespace frontend\models\mysql;

/**
 * This is the ActiveQuery class for [[MysqlInt]].
 *
 * @see MysqlInt
 */
class MysqlIntQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return MysqlInt[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MysqlInt|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
