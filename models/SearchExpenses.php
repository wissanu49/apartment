<?php

namespace app\Models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Expenses;

/**
 * SearchExpenses represents the model behind the search form of `app\models\Expenses`.
 */
class SearchExpenses extends Expenses
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'expenses_1_price', 'expenses_2_price', 'expenses_3_price', 'expenses_4_price', 'expenses_5_price', 'total', 'users_id'], 'integer'],
            [['expenses_1', 'expenses_2', 'expenses_3', 'expenses_4', 'expenses_5', 'date_record'], 'safe'],
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
        $query = Expenses::find()->orderBy('date_record DESC');

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
            'id' => $this->id,
            'expenses_1_price' => $this->expenses_1_price,
            'expenses_2_price' => $this->expenses_2_price,
            'expenses_3_price' => $this->expenses_3_price,
            'expenses_4_price' => $this->expenses_4_price,
            'expenses_5_price' => $this->expenses_5_price,
            'total' => $this->total,
            'date_record' => $this->date_record,
            'users_id' => $this->users_id,
        ]);

        $query->andFilterWhere(['like', 'expenses_1', $this->expenses_1])
            ->andFilterWhere(['like', 'expenses_2', $this->expenses_2])
            ->andFilterWhere(['like', 'expenses_3', $this->expenses_3])
            ->andFilterWhere(['like', 'expenses_4', $this->expenses_4])
            ->andFilterWhere(['like', 'expenses_5', $this->expenses_5]);

        return $dataProvider;
    }
}
