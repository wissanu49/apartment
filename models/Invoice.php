<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "invoice".
 *
 * @property string $id
 * @property string $leasing_id
 * @property int $room_price
 * @property int $electric_unit หน่วยไฟฟ้า
 * @property int $electric_price ค่าไฟฟ้า
 * @property int $water_unit หน่วยน้ำปะปา
 * @property int $water_price ค่าน้ำ
 * @property string $additional_1 ค่าใช้จ่ายเพิ่มเติม
 * @property int $additional_1_price บาท
 * @property string $additional_2 ค่าใช้จ่ายเพิ่มเติม
 * @property int $additional_2_price บาท
 * @property string $additional_3 ค่าใช้จ่ายเพิ่มเติม
 * @property int $additional_3_price บาท
 * @property string $additional_4 ค่าใช้จ่ายเพิ่มเติม
 * @property int $additional_4_price บาท
 * @property string $additional_5 ค่าใช้จ่ายเพิ่มเติม
 * @property int $additional_5_price บาท
 * @property string $refun_1 คืนเงิน
 * @property int $refun_1_price
 * @property string $refun_2 คืนเงิน
 * @property int $refun_2_price
 * @property int $total รวม
 * @property string $comment หมายเหตุ
 * @property string $appointment วันกำหนดชำระ
 * @property string $status สถานะการชำระ
 * @property int $users_id
 * @property string $invoice_date วันที่ออกใบแจ้งหนี้
 *
 * @property Users $users
 * @property Leasing $leasing
 * @property Receipt[] $receipts
 */
class Invoice extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'invoice';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'leasing_id', 'rooms_id' ,'rental', 'electric_price','water_price', 'total', 'appointment', 'users_id', 'invoice_date'], 'required'],
            [['rental', 'rooms_id' ,'deposit', 'electric_unit_from','electric_unit_to', 'electric_price', 'water_unit_from','water_unit_to', 'water_price', 'additional_1_price', 'additional_2_price', 'additional_3_price', 'additional_4_price', 'additional_5_price', 'refun_1_price', 'refun_2_price', 'total'], 'double'],
            [[ 'users_id'], 'integer'],
            [['appointment', 'invoice_date'], 'safe'],
            [['status'], 'string'],
            [['id', 'leasing_id'], 'string', 'max' => 25],
            [['additional_1', 'additional_2', 'additional_3', 'additional_4', 'additional_5', 'refun_1', 'refun_2'], 'string', 'max' => 100],
            
            [['comment'], 'string', 'max' => 255],
            [['id'], 'unique'],
            [['users_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['users_id' => 'id']],
            [['leasing_id'], 'exist', 'skipOnError' => true, 'targetClass' => Leasing::className(), 'targetAttribute' => ['leasing_id' => 'id']],
            [['rooms_id'], 'exist', 'skipOnError' => true, 'targetClass' => Rooms::className(), 'targetAttribute' => ['rooms_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'เลขใบแจ้งหนี้',
            'leasing_id' => 'เลขสัญญา',
            'rooms_id' => 'ห้องพัก',
            'rental' => 'ค่าห้อง',
            'deposit' => 'ค่าประกันห้อง',
            'electric_unit_from' => 'หน่วยไฟฟ้าครั้งก่อน',
            'electric_unit_to' => 'หน่วยไฟฟ้าล่าสุด',
            'electric_price' => 'ค่าไฟฟ้า',
            'water_unit_from' => 'หน่วยน้ำปะปาครั้งก่อน',
            'water_unit_to' => 'หน่วยน้ำปะปาล่าสุด',
            'water_price' => 'ค่าน้ำ',
            'additional_1' => 'ค่าใช้จ่ายเพิ่มเติม',
            'additional_1_price' => 'บาท',
            'additional_2' => 'ค่าใช้จ่ายเพิ่มเติม',
            'additional_2_price' => 'บาท',
            'additional_3' => 'ค่าใช้จ่ายเพิ่มเติม',
            'additional_3_price' => 'บาท',
            'additional_4' => 'ค่าใช้จ่ายเพิ่มเติม',
            'additional_4_price' => 'บาท',
            'additional_5' => 'ค่าใช้จ่ายเพิ่มเติม',
            'additional_5_price' => 'บาท',
            'refun_1' => 'คืนเงิน',
            'refun_1_price' => 'คืนเงิน',
            'refun_2' => 'คืนเงิน',
            'refun_2_price' => 'คืนเงิน',
            'total' => 'รวม',
            'comment' => 'หมายเหตุ',
            'appointment' => 'วันกำหนดชำระ',
            'status' => 'สถานะการชำระ',
            'users_id' => 'Users ID',
            'invoice_date' => 'วันที่ออกใบแจ้งหนี้',
            //'water_unit_total' => 'หน่วยน้ำปะปารวม',
            //'electric_unit_total' => 'หน่วยไฟฟ้ารวม',
        ];
    }

    public function scenarios() {
        $sn = parent::scenarios();
        $sn['changestatus'] = ['status'];
        $sn['deposit'] = ['id', 'rental', 'deposit', 'total', 'users_id', 'appointment'];
        $sn['create'] = ['id', 'rooms_id', 'rental', 'deposit', 'electric_unit_from','electric_unit_to', 'electric_price', 'water_unit_from', 'water_unit_to','water_price', 
            'additional_1', 'additional_1_price' ,
            'additional_2', 'additional_2_price','additional_3', 'additional_3_price','additional_4', 'additional_4_price','additional_5', 'additional_5_price',
            'total', 'appointment', 'users_id', 'invoice_date'];
        $sn['checkout'] = ['id', 'rooms_id', 'rental', 'deposit', 'electric_unit_from','electric_unit_to', 'electric_price', 'water_unit_from', 'water_unit_to','water_price',
            'additional_1', 'additional_1_price', 'additional_2', 'additional_2_price','additional_3', 'additional_3_price','additional_4', 'additional_4_price','additional_5',
            'additional_5_price','refun_1','refun_1_price', 'refun_2','refun_2_price','total', 'appointment', 'users_id', 'invoice_date'];
        return $sn;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers() {
        return $this->hasOne(Users::className(), ['id' => 'users_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLeasing() {
        return $this->hasOne(Leasing::className(), ['id' => 'leasing_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceipts() {
        return $this->hasMany(Receipt::className(), ['invoice_id' => 'id']);
    }
    
    public function getRooms() {
        return $this->hasMany(Rooms::className(), ['id' => 'rooms_id']);
    }

    /**
     * {@inheritdoc}
     * @return InvoiceQuery the active query used by this AR class.
     */
    public static function find() {
        return new InvoiceQuery(get_called_class());
    }

    public function checkInvoice($id) {
        $get = Invoice::find()->select('leasing_id')->where(['leasing_id' => $id])->one();
        if (isset($get->leasing_id)) {
            return true;
        } else {
            return false;
        }
    }

}
