<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $username ชื่อผู้ใช้งาน
 * @property string $password รหัสผ่าน
 * @property string $fullname ชื่อ-นามสกุล
 * @property string $role สิทธิ์การใช้งาน
 * @property string $status สถานะ
 *
 * @property Expenses[] $expenses
 * @property Invoice[] $invoices
 * @property Leasing[] $leasings
 * @property Receipt[] $receipts
 * @property RecordEnergies[] $recordEnergies
 */
class Users extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface {

    //private static $users;
    //public $password;
    public $new_password;
    public $repeat_password;
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['username', 'password', 'fullname'], 'required'],
            [['role', 'status'], 'string'],
            [['username', 'fullname'], 'string', 'max' => 100],
            [['authKey', 'password'], 'string', 'max' => 300],
            [['password', 'new_password', 'repeat_password'], 'required', 'on' => 'changepwd'],
        ];
    }

     public function scenarios() {
        $sn = parent::scenarios();
        $sn['create'] = ['fullname', 'username', 'password', 'status', 'role'];
        $sn['update'] = ['fullname', 'username', 'status', 'role'];
        $sn['changepwd'] = ['new_password', 'repeat_password'];
        return $sn;
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'username' => 'ชื่อผู้ใช้งาน',
            'password' => 'รหัสผ่าน',
            'fullname' => 'ชื่อ-นามสกุล',
            'role' => 'สิทธิ์การใช้งาน',
            'status' => 'สถานะ',
            'authKey' => 'authkey',
            'new_password' => 'รหัสผ่านใหม่',
            'repeat_password' => 'ยืนยันรหัสผ่านใหม่',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExpenses() {
        return $this->hasMany(Expenses::className(), ['users_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoices() {
        return $this->hasMany(Invoice::className(), ['users_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLeasings() {
        return $this->hasMany(Leasing::className(), ['users_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceipts() {
        return $this->hasMany(Receipt::className(), ['users_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecordEnergies() {
        return $this->hasMany(RecordEnergies::className(), ['users_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
   public function getAuthKey() {
        return $this->authKey;
    }

    public function getId() {
        return $this->id;
    }

    public function validateAuthKey($authKey) {
        return $this->authKey === $authKey;
    }

    public static function findIdentity($id) {
         return self::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null) {
        throw new \yii\base\NotSupportedException();
    }
    
    public function validatePassword($password) {
        //$hash = Yii::$app->getSecurity()->generatePasswordHash($this->password);
        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
        //return $this->password === $password;
        
    }
    
    public static function findByUsername($username) {
        return self::findOne(['username' => $username, 'status' => 'active']);
    }
    
    
    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) { // <---- the difference
                $this->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
                $this->authKey = Yii::$app->getSecurity()->generateRandomString();
                
            }// else {
                //$this->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
                //$this->authKey = Yii::$app->getSecurity()->generateRandomString();
            //}
            return true;
        }
        return false;
    }
    
    public function getRole() {
        $profile = Users::find()->where(['id' => $this->id])->one();
        if ($profile !== null) {
            return $profile->role;
        } else {
            return false;
        }
    }
    
}
