<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "customers".
 *
 * @property int $id
 * @property string $fullname ชื่อ-นามสกุล
 * @property string $address ที่อยู่
 * @property string $work_address สถานที่ทำงาน
 * @property string $phone เบอร์ติดต่อ
 * @property string $citizen รหัสบัตรประชาชน
 * @property string $gender เพศ
 *
 * @property Leasing[] $leasings
 */
class Customers extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'customers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['fullname', 'address', 'gender'], 'required'],
            [['address', 'work_address', 'gender'], 'string'],
            [['fullname', 'phone', 'citizen'], 'string', 'max' => 45],
            [['citizen'], 'validateIdCard'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'fullname' => 'ชื่อ-นามสกุล',
            'address' => 'ที่อยู่',
            'work_address' => 'สถานที่ทำงาน',
            'phone' => 'เบอร์ติดต่อ',
            'citizen' => 'รหัสบัตรประชาชน',
            'gender' => 'เพศ',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLeasings() {
        return $this->hasMany(Leasing::className(), ['customers_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return CustomersQuery the active query used by this AR class.
     */
    public static function find() {
        return new CustomersQuery(get_called_class());
    }

    public function getFullname($id) {
        $get = Customers::find()->select('fullname')->where(['id' => $id])->one();
        if ($get != NULL) {
            return $get->fullname;
        } else {
            return NULL;
        }
    }

    public function validateIdCard() {
        $id = str_split(str_replace('-', '', $this->citizen)); //ตัดรูปแบบและเอา ตัวอักษร ไปแยกเป็น array $id
        $sum = 0;
        $total = 0;
        $digi = 13;

        for ($i = 0; $i < 12; $i++) {
            $sum = $sum + (intval($id[$i]) * $digi);
            $digi--;
        }
        $total = (11 - ($sum % 11)) % 10;

        if ($total != $id[12]) { //ตัวที่ 13 มีค่าไม่เท่ากับผลรวมจากการคำนวณ ให้ add error
            $this->addError('citizen', 'หมายเลขบัตรประชาชนไม่ถูกต้อง');
        }
    }

}
