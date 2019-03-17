<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Energies]].
 *
 * @see Energies
 */
class EnergiesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Energies[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Energies|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
