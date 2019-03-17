<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Leasing]].
 *
 * @see Leasing
 */
class LeasingQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Leasing[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Leasing|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
