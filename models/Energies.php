<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "energies".
 *
 * @property int $id
 * @property string $peroid รอบเดือน
 * @property int $water_unit เลขมิเตอร์น้ำ
 * @property int $electric_unit เลขมิเตอร์ไฟฟ้า
 * @property int $rooms_id
 * @property int $users_id ผู้จดบันทึก
 * @property string $record_date วันที่บันทึก
 *
 * @property Rooms $rooms
 * @property Users $users
 */
class Energies extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $items;
    public static function tableName()
    {
        return 'energies';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['peroid', 'water_unit', 'electric_unit', 'rooms_id', 'users_id', 'record_date'], 'required'],
            [['water_unit', 'electric_unit', 'rooms_id', 'users_id'], 'integer'],
            [['record_date', 'peroid'], 'safe'],
            [['peroid', 'water_unit', 'electric_unit', 'rooms_id'], 'required', 'on' => 'add_data'],
            [['rooms_id'], 'exist', 'skipOnError' => true, 'targetClass' => Rooms::className(), 'targetAttribute' => ['rooms_id' => 'id']],
            [['users_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['users_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'peroid' => 'รอบเดือน',
            'water_unit' => 'เลขมิเตอร์น้ำ',
            'electric_unit' => 'เลขมิเตอร์ไฟฟ้า',
            'rooms_id' => 'Rooms ID',
            'users_id' => 'ผู้จดบันทึก',
            'record_date' => 'วันที่บันทึก',
            'items' => 'items',
        ];
    }

    public function scenarios() {
        $sn = parent::scenarios();
        $sn['add_data'] = ['id','peroid', 'water_unit', 'electric_unit', 'rooms_id'];
        
        return $sn;
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRooms()
    {
        return $this->hasOne(Rooms::className(), ['id' => 'rooms_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasOne(Users::className(), ['id' => 'users_id']);
    }

    /**
     * {@inheritdoc}
     * @return EnergiesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EnergiesQuery(get_called_class());
    }
    
    public function getElectric($room){
        $get = Energies::find()->select(['electric_unit', 'peroid'])->where(['rooms_id' => $room])->orderBy('peroid DESC')->limit(2)->all();
        //die(print_r($get));
        if($get != NULL){
            return $get;
        }else{
            //$get->electric_unit = "-";
            //$get->peroid = "-";
            return $get;
        }
    }
    
    
    public function getWater($room){
        $get = Energies::find()->select(['water_unit','peroid'])->where(['rooms_id' => $room])->orderBy('peroid DESC')->limit(2)->all();
        if($get != NULL){
            return $get;
        }else{
            //$get->water_unit = "ไม่พบข้อมูล";
            //$get->peroid = "-";
            return $get;
        }
    }
}
