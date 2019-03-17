<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "company".
 *
 * @property int $id
 * @property string $company_name
 * @property string $address
 * @property string $phone
 * @property string $logo
 * @property int $electric ค่าไฟฟ้าต่อหน่วย
 * @property int $water ค่าน้ำต่อหน่วย
 */
class Company extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'company';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_name', 'address', 'electric', 'water'], 'required'],
            [['electric', 'water'], 'double'],
            [['company_name','address', 'logo'], 'string', 'max' => 500],
            [['phone'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_name' => 'ชื่อบริษัท',
            'address' => 'ที่อยู่',
            'phone' => 'โทรศัพท์',
            'logo' => 'Logo',
            'electric' => 'ค่าไฟฟ้าต่อหน่วย',
            'water' => 'ค่าน้ำต่อหน่วย',
        ];
    }

    /**
     * {@inheritdoc}
     * @return CompanyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CompanyQuery(get_called_class());
    }
    
    public static function companyName() {
        $query = Company::find()->select('company_name')->one();
        echo $query->company_name;
    }
    
    public static function companyProfile($id) {
        $query = Company::find()->all();
        echo $query;
    }
}
