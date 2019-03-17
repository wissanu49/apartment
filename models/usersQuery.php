<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[users]].
 *
 * @see users
 */
class usersQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return users[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return users|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
