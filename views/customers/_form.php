<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model app\models\Customers */
/* @var $form yii\widgets\ActiveForm */
?>


<?php
$form = ActiveForm::begin();
?>
<div class="row">
    <div class="col-xs-3 col-sm-3 col-md-3">
        <?= $form->field($model, 'gender')->dropDownList(['ชาย' => 'ชาย', 'หญิง' => 'หญิง',], ['prompt' => 'เพศ', 'class' => 'form-control']) ?>
    </div>
    <div class="col-xs-3 col-sm-3 col-md-3">
        <?= $form->field($model, 'fullname')->textInput(['maxlength' => true, 'placeholder' => 'ชื่อ-นามสกุล', 'class' => 'form-control']) ?>
    </div>
    <div class="col-xs-3 col-sm-3 col-md-3">
        <?=
$form->field($model, 'citizen')->widget(MaskedInput::className(), [
    'mask' => '9-9999-99999-99-9',
])
?> 
    </div>
    <div class="col-xs-3 col-sm-3 col-md-3">
        <?= $form->field($model, 'phone')->textInput(['maxlength' => true, 'placeholder' => 'เบอร์โทรศัพท์']) ?> 
    </div>
</div>


<?= $form->field($model, 'address')->textarea(['rows' => 6, 'placeholder' => 'ที่อยู่']) ?>

<?= $form->field($model, 'work_address')->textarea(['rows' => 6, 'placeholder' => 'สถานที่ทำงาน']) ?>

 


<div class="form-group">
    <?= Html::submitButton(' บันทึก', ['class' => 'btn btn-success btn-lg fa fa-save']) ?>
</div>

<?php ActiveForm::end(); ?>
   
