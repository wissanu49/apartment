<?php

namespace app\Models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RecordEnergies;

/**
 * SearchRecordEnergies represents the model behind the search form of `app\models\RecordEnergies`.
 */
class SearchRecordEnergies extends RecordEnergies
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'water_unit', 'electric_unit', 'rooms_id', 'users_id'], 'integer'],
            [['peroid', 'record_date'], 'safe'],
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
        $query = RecordEnergies::find();

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
            'water_unit' => $this->water_unit,
            'electric_unit' => $this->electric_unit,
            'rooms_id' => $this->rooms_id,
            'users_id' => $this->users_id,
            'record_date' => $this->record_date,
        ]);

        $query->andFilterWhere(['like', 'peroid', $this->peroid]);

        return $dataProvider;
    }
}
