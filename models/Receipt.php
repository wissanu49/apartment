<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "receipt".
 *
 * @property string $id
 * @property string $leasing_id
 * @property int $room_price
 * @property int $electric_price ค่าไฟฟ้า
 * @property int $water_price ค่าน้ำ
 * @property string $additional_1 ค่าใช้จ่ายเพิ่มเติม
 * @property int $additional_1_price
 * @property string $additional_2
 * @property int $additional_2_price
 * @property string $additional_3
 * @property int $additional_3_price
 * @property string $additional_4
 * @property int $additional_4_price
 * @property string $additional_5
 * @property int $additional_5_price
 * @property string $refun_1
 * @property int $refun_1_price
 * @property string $refun_2
 * @property int $refun_2_price
 * @property int $total
 * @property string $comment หมายเหตุ
 * @property string $invoice_id
 * @property int $users_id
 * @property string $receipt_date
 *
 * @property Leasing $leasing
 * @property Invoice $invoice
 * @property Users $users
 */
class Receipt extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'receipt';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'leasing_id', 'rental', 'total', 'invoice_id', 'users_id'], 'required'],
            [['rental', 'deposit', 'electric_price', 'water_price', 'additional_1_price', 'additional_2_price', 'additional_3_price', 'additional_4_price', 'additional_5_price', 'refun_1_price', 'refun_2_price', 'total'], 'double'],
            [['users_id'], 'integer'],
            [['receipt_date', 'status'], 'safe'],
            [['id', 'leasing_id', 'invoice_id'], 'string', 'max' => 25],
            [['additional_1', 'additional_2', 'additional_3', 'additional_4', 'additional_5', 'refun_1', 'refun_2'], 'string', 'max' => 200],
            [['comment'], 'string', 'max' => 255],
            [['id'], 'unique'],
            [['status'], 'required', 'on' => 'update_status'],
            [['leasing_id'], 'exist', 'skipOnError' => true, 'targetClass' => Leasing::className(), 'targetAttribute' => ['leasing_id' => 'id']],
            [['invoice_id'], 'exist', 'skipOnError' => true, 'targetClass' => Invoice::className(), 'targetAttribute' => ['invoice_id' => 'id']],
            [['users_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['users_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'เลขใบเสร็จรับเงิน',
            'leasing_id' => 'สัญญาเช่า',
            'rental' => 'ค่าเช่า',
            'deposit' => 'ค่าประกันห้อง',
            'electric_price' => 'ค่าไฟฟ้า',
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
            'total' => 'ยอดรวม',
            'comment' => 'หมายเหตุ',
            'invoice_id' => 'เลขใบแจ้งหนี้',
            'users_id' => 'ผู้รับเงิน',
            'receipt_date' => 'วันที่ชำระ',
            'status' => 'สถานะ',
        ];
    }

    public function scenarios() {
        $sn = parent::scenarios();
        $sn['update_status'] = ['status'];
        return $sn;
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
    public function getInvoice() {
        return $this->hasOne(Invoice::className(), ['id' => 'invoice_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers() {
        return $this->hasOne(Users::className(), ['id' => 'users_id']);
    }

    /**
     * {@inheritdoc}
     * @return ReceiptQuery the active query used by this AR class.
     */
    public static function find() {
        return new ReceiptQuery(get_called_class());
    }

    public function ReceiptMonthly() {
        $start = date("Y-m-d", strtotime("first day of this month"));
        $stop = date("Y-m-d", strtotime("last day of this month"));
        //$sql = "SELECT sum(total) as income FROM receipt WHERE status = 'narmal' AND receipt_date BETWEEN '" . $start . "' AND '" . $stop . "'";
        //die($sql);
        $command = Yii::$app->db->createCommand("SELECT sum(total) as income FROM receipt WHERE status = 'normal' AND receipt_date BETWEEN '" . $start . "' AND '" . $stop . "'");
        $sum = $command->queryScalar();
        //die(var_dump($sum));
        if ($sum == NULL) {
            return 0;
        } else {
            return $sum;
        }
    }

    public function getSummary_income() {

        $year = date('Y');
        $cm = date('m', strtotime('NOW'));
        switch ($cm) {
            case '01' :
                $query = 1;
                break;
            case '02' :
                $query = 2;
                break;
            case '03' :
                $query = 3;
                break;
            case '04' :
                $query = 4;
                break;
            case '05' :
                $query = 5;
                break;
            case '06' :
                $query = 6;
                break;
            case '07' :
                $query = 7;
                break;
            case '08' :
                $query = 8;
                break;
            case '09' :
                $query = 9;
                break;
            case '10' :
                $query = 10;
                break;
            case '11' :
                $query = 11;
                break;
            case '12' :
                $query = 12;
                break;
        }

        $ThaiMonth = ['', 'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];
        for ($i = 1; $i <= $query; $i++) {

            $date = $year . "-" . $i . "-01";
            $newDate = new \DateTime($date);
            $fm = $newDate->modify("first day of this month");
            $firstday = $fm->format('Y-m-d');
            $fm2 = $newDate->modify("last day of this month");
            $lastday = $fm2->format('Y-m-d');
            
            $command = Yii::$app->db->createCommand("SELECT sum(total) as income FROM receipt WHERE receipt_date BETWEEN '" . $firstday . "' AND '" . $lastday . "' AND status = 'normal'");
            $sum = $command->queryScalar();
            if ($sum == NULL) {
                $arrData[$i]['val'] = 0;
                $arrData[$i]['month'] = $ThaiMonth[$i];
            } else {
                $arrData[$i]['val'] = $sum;
                $arrData[$i]['month'] = $ThaiMonth[$i];
                ;
            }
        }
        //print_r($arrData);
        return $arrData;
    }

    public function getEnergiesexp() {

        $year = date('Y');
        $cm = date('m', strtotime('NOW'));
        switch ($cm) {
            case '01' :
                $query = 1;
                break;
            case '02' :
                $query = 2;
                break;
            case '03' :
                $query = 3;
                break;
            case '04' :
                $query = 4;
                break;
            case '05' :
                $query = 5;
                break;
            case '06' :
                $query = 6;
                break;
            case '07' :
                $query = 7;
                break;
            case '07' :
                $query = 8;
                break;
            case '09' :
                $query = 9;
                break;
            case '10' :
                $query = 10;
                break;
            case '11' :
                $query = 11;
                break;
            case '12' :
                $query = 12;
                break;
        }

        $ThaiMonth = ['', 'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];
        for ($i = 1; $i <= $query; $i++) {
            
            $date = $year . "-" . $i . "-01";
            $newDate = new \DateTime($date);
            $fm = $newDate->modify("first day of this month");
            $firstday = $fm->format('Y-m-d');
            $fm2 = $newDate->modify("last day of this month");
            $lastday = $fm2->format('Y-m-d');

            $cmd = Yii::$app->db->createCommand("SELECT sum(rental) as rental  FROM receipt WHERE receipt_date BETWEEN '" . $firstday . "' AND '" . $lastday . "' AND status = 'normal'");
            $sum = $cmd->queryScalar();
            $cmd2 = Yii::$app->db->createCommand("SELECT sum(electric_price) as electric  FROM receipt WHERE receipt_date BETWEEN '" . $firstday . "' AND '" . $lastday . "' AND status = 'normal'");
            $sum2 = $cmd->queryScalar();
            $cmd3 = Yii::$app->db->createCommand("SELECT sum(water_price) as water_price FROM receipt WHERE receipt_date BETWEEN '" . $firstday . "' AND '" . $lastday . "' AND status = 'normal'");
            $sum3 = $cmd->queryScalar();
            //$sum = Receipt::find()->select(['SUM(rental) as rental','SUM(water_price) as water_price','SUM(electric_price) as electric_price'])->where(['month(receipt_date)'=>$i])->all();
            //die(print_r($sum));
            /*
              if ($sum == NULL) {
              $arrData[$i]['rental'] = 0;
              $arrData[$i]['water_price'] = 0;
              $arrData[$i]['electric_price'] = 0;
              $arrData[$i]['month'] = $ThaiMonth[$i];
              } else {
              $arrData[$i]['rental'] = $sum;
              $arrData[$i]['water_price'] = $sum;
              $arrData[$i]['electric_price'] = $sum;
              $arrData[$i]['month'] = $ThaiMonth[$i];
              }
             * 
             */

            $arrData[$i]['rental'] = $sum;
            $arrData[$i]['water_price'] = $sum3;
            $arrData[$i]['electric_price'] = $sum2;
            $arrData[$i]['month'] = $ThaiMonth[$i];
        }
       // print_r($arrData);
        return $arrData;
    }

}
