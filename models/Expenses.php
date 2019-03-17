<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "expenses".
 *
 * @property int $id
 * @property string $expenses_1 ค่าใช้จ่าย
 * @property int $expenses_1_price
 * @property string $expenses_2 ค่าใช้จ่าย
 * @property int $expenses_2_price
 * @property string $expenses_3 ค่าใช้จ่าย
 * @property int $expenses_3_price
 * @property string $expenses_4 ค่าใช้จ่าย
 * @property int $expenses_4_price
 * @property string $expenses_5 ค่าใช้จ่าย
 * @property int $expenses_5_price
 * @property int $total รวมค่าใช้จ่าย
 * @property string $date_record วันที่บึนทึก
 * @property int $users_id
 *
 * @property Users $users
 */
class Expenses extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'expenses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['expenses_1', 'expenses_1_price', 'total', 'users_id', 'date_record'], 'required'],
            [['users_id'], 'integer'],
            [['expenses_1_price', 'expenses_2_price', 'expenses_3_price', 'expenses_4_price', 'expenses_5_price','expenses_6_price','expenses_7_price','expenses_8_price','expenses_9_price','expenses_10_price', 'total'], 'double'],
            [['date_record'], 'safe'],
            [['expenses_1', 'expenses_2', 'expenses_3', 'expenses_4', 'expenses_5', 'expenses_6', 'expenses_7', 'expenses_8', 'expenses_9', 'expenses_10'], 'string', 'max' => 200],
            [['users_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['users_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'expenses_1' => 'ค่าใช้จ่าย',
            'expenses_1_price' => 'จำนวนเงิน',
            'expenses_2' => 'ค่าใช้จ่าย',
            'expenses_2_price' => 'จำนวนเงิน',
            'expenses_3' => 'ค่าใช้จ่าย',
            'expenses_3_price' => 'จำนวนเงิน',
            'expenses_4' => 'ค่าใช้จ่าย',
            'expenses_4_price' => 'จำนวนเงิน',
            'expenses_5' => 'ค่าใช้จ่าย',
            'expenses_5_price' => 'จำนวนเงิน',
            'expenses_6' => 'ค่าใช้จ่าย',
            'expenses_6_price' => 'จำนวนเงิน',
            'expenses_7' => 'ค่าใช้จ่าย',
            'expenses_7_price' => 'จำนวนเงิน',
            'expenses_8' => 'ค่าใช้จ่าย',
            'expenses_8_price' => 'จำนวนเงิน',
            'expenses_9' => 'ค่าใช้จ่าย',
            'expenses_9_price' => 'จำนวนเงิน',
            'expenses_10' => 'ค่าใช้จ่าย',
            'expenses_10_price' => 'จำนวนเงิน',
            'total' => 'รวมค่าใช้จ่าย',
            'date_record' => 'วันที่บึนทึก',
            'users_id' => 'ผู้บันทึก',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers() {
        return $this->hasOne(Users::className(), ['id' => 'users_id']);
    }

    /**
     * {@inheritdoc}
     * @return ExpensesQuery the active query used by this AR class.
     */
    public static function find() {
        return new ExpensesQuery(get_called_class());
    }

    public function ExpensesMonthly() {
        $start = date("Y-m-d", strtotime("first day of this month"));
        $stop = date("Y-m-d", strtotime("last day of this month"));
        //$sql = "SELECT sum(total) as income FROM receipt WHERE status = 'narmal' AND receipt_date BETWEEN '" . $start . "' AND '" . $stop . "'";
        //die($sql);
        $command = Yii::$app->db->createCommand("SELECT sum(total) as income FROM expenses WHERE date_record BETWEEN '" . $start . "' AND '" . $stop . "'");
        $sum = $command->queryScalar();
        //die(var_dump($sum));
        if ($sum == NULL) {
            return 0;
        } else {
            return $sum;
        }
    }

    public function getSummary_exp() {

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

            $command = Yii::$app->db->createCommand("SELECT sum(total) as income FROM expenses WHERE month(date_record) = '" . $i . "'");
            $sum = $command->queryScalar();
            if ($sum == NULL) {
                $arrData[$i]['val'] = 0;
                $arrData[$i]['month'] = $ThaiMonth[$i];
            } else {
                $arrData[$i]['val'] = $sum;
                $arrData[$i]['month'] = $ThaiMonth[$i];
                
            }
        }
        //print_r($arrData);
        return $arrData;
    }

}
