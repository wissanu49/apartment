<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rooms".
 *
 * @property int $id รหัสห้อง
 * @property string $name ชื่อห้อง/เลขห้อง
 * @property int $monthly_price ราคาต่อเเดือน
 * @property string $details รายละเอียดห้อง
 * @property string $type ประเภทห้อง
 * @property string $daily_price ราคารายวัน
 * @property int $building_id
 *
 * @property Leasing[] $leasings
 * @property RecordEnergies[] $recordEnergies
 * @property Building $building
 */
class Rooms extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rooms';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'monthly_price', 'building_id'], 'required'],
            [['monthly_price', 'building_id', 'deposit', 'daily_price'], 'integer'],
            [['details', 'type','status'], 'string'],
            [['name'], 'string', 'max' => 45],
            [['name'], 'unique'],
            [['status'], 'required', 'on'=>'changestatus'],
            [['building_id'], 'exist', 'skipOnError' => true, 'targetClass' => Building::className(), 'targetAttribute' => ['building_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'รหัสห้อง',
            'name' => 'ชื่อห้อง/เลขห้อง',
            'monthly_price' => 'ราคาต่อเเดือน',
            'details' => 'รายละเอียดห้อง',
            'type' => 'ประเภทห้อง',
            'daily_price' => 'ราคารายวัน',
            'deposit' => 'ประกันห้อง',
            'building_id' => 'ตึก/อาคาร',
            'status' => 'สถานะ',
        ];
    }

     public function scenarios() {
        $sn = parent::scenarios();
        $sn['changestatus'] = ['status'];
         return $sn;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLeasings()
    {
        return $this->hasMany(Leasing::className(), ['rooms_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecordEnergies()
    {
        return $this->hasMany(RecordEnergies::className(), ['rooms_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBuilding()
    {
        return $this->hasOne(Building::className(), ['id' => 'building_id']);
    }

    /**
     * {@inheritdoc}
     * @return RoomsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RoomsQuery(get_called_class());
    }
    
    public function getRoomname($id) {
        $get = Rooms::find()->select('name')->where(['id'=>$id])->one();
        return $get->name;
    }
     public function getPrice($id) {
        $get = Rooms::find()->select('monthly_price')->where(['id'=>$id])->one();
        return $get->monthly_price;
    }
    
    public function getDeposit($id) {
        $get = Rooms::find()->select('deposit')->where(['id'=>$id])->one();
        return $get->deposit;
    }
    
    public function showName($id) {
        $get = Rooms::find()->select('name')->where(['id'=>$id])->one();
        echo $get->name;
    }
    
    
    
}
