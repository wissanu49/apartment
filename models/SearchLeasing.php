<?php

namespace app\Models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Leasing;

/**
 * SearchLeasing represents the model behind the search form of `app\models\Leasing`.
 */
class SearchLeasing extends Leasing
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'move_in', 'move_out', 'leasing_date', 'status', 'comment'], 'safe'],
            [['users_id', 'rooms_id', 'customers_id', 'deposit'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Leasing::find()->orderBy('id DESC');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'move_in' => $this->move_in,
            'move_out' => $this->move_out,
            'users_id' => $this->users_id,
            'rooms_id' => $this->rooms_id,
            'customers_id' => $this->customers_id,
            'leasing_date' => $this->leasing_date,
            'deposit' => $this->deposit,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
