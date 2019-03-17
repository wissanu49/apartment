<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Users */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'password')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'new_password')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'repeat_password')->textInput(['maxlength' => true]) ?>


    <div class="form-group">
        <?= Html::submitButton(' บันทึก', ['class' => 'btn btn-success fa fa-save']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
