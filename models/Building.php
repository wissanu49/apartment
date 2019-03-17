<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "building".
 *
 * @property int $id
 * @property string $building_name
 * @property string $building_address
 *
 * @property Rooms[] $rooms
 */
class Building extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'building';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['building_name','company_id'], 'required'],
            [['company_id'], 'integer'],
            [['building_name', 'building_address'], 'string', 'max' => 500],
            //[['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'company_id' => 'ข้อมูลใบแจ้งหนี้',
            'building_name' => 'ชื่ออาคาร',
            'building_address' => 'ที่อยู่/สถานที่',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRooms() {
        return $this->hasMany(Rooms::className(), ['building_id' => 'id']);
    }

    public function getCompany() {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }
    /**
     * {@inheritdoc}
     * @return BuildingQuery the active query used by this AR class.
     */
    public static function find() {
        return new BuildingQuery(get_called_class());
    }

    public static function getBuilding() {
        $query = Building::find()->all();
        return $query;
    }

    public static function getBuildingName($id) {
        $query = Building::find()->select('building_name')->where(['id'=>$id])->one();
        echo $query->building_name;
    }
    public static function getBuildingId($id) {
        $query = Building::find()->select('id')->where(['id'=>$id])->one();
        echo $query->id;
    }

}
