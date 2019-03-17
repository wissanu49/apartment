<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Building */
/* @var $form yii\widgets\ActiveForm */
?>


    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'building_name')->textInput(['maxlength' => true, 'placeholder' => 'ตึก/อาคาร']) ?>

    <?= $form->field($model, 'building_address')->textarea(['rows' => 6, 'placeholder' => 'ที่อยู่อาคาร/สถานที่']) ?>

    <div class="form-group">
        <?= Html::submitButton(' บันทึก', ['class' => 'btn btn-success fa fa-save']) ?>
    </div>

    <?php ActiveForm::end(); ?>


