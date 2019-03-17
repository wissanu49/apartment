<?php

namespace app\Models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Receipt;

/**
 * SearchReceipt represents the model behind the search form of `app\models\Receipt`.
 */
class SearchReceipt extends Receipt {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'leasing_id', 'additional_1', 'additional_2', 'additional_3', 'additional_4', 'additional_5', 'refun_1', 'refun_2', 'comment', 'invoice_id', 'receipt_date','status'], 'safe'],
            [['rental', 'electric_price', 'water_price', 'additional_1_price', 'additional_2_price', 'additional_3_price', 'additional_4_price', 'additional_5_price', 'refun_1_price', 'refun_2_price', 'total', 'users_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios() {
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
    public function search($params) {
        $query = Receipt::find()->orderBy('id DESC');

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
            'rental' => $this->rental,
            'electric_price' => $this->electric_price,
            'water_price' => $this->water_price,
            'additional_1_price' => $this->additional_1_price,
            'additional_2_price' => $this->additional_2_price,
            'additional_3_price' => $this->additional_3_price,
            'additional_4_price' => $this->additional_4_price,
            'additional_5_price' => $this->additional_5_price,
            'refun_1_price' => $this->refun_1_price,
            'refun_2_price' => $this->refun_2_price,
            'total' => $this->total,
            'users_id' => $this->users_id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
        ->andFilterWhere(['like', 'leasing_id', $this->leasing_id])
        ->andFilterWhere(['like', 'additional_1', $this->additional_1])
        ->andFilterWhere(['like', 'additional_2', $this->additional_2])
        ->andFilterWhere(['like', 'additional_3', $this->additional_3])
        ->andFilterWhere(['like', 'additional_4', $this->additional_4])
        ->andFilterWhere(['like', 'additional_5', $this->additional_5])
        ->andFilterWhere(['like', 'refun_1', $this->refun_1])
        ->andFilterWhere(['like', 'refun_2', $this->refun_2])
        ->andFilterWhere(['like', 'comment', $this->comment])
        ->andFilterWhere(['like', 'invoice_id', $this->invoice_id])
        ->andFilterWhere(['like', 'receipt_date', $this->receipt_date]);

        return $dataProvider;
    }

}
