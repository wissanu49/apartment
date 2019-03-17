<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Users */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fullname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'role')->dropDownList([ 'user' => 'User', 'admin' => 'Admin', ], ['prompt' => 'สิทธิ์การใช้งาน']) ?>

    <?= $form->field($model, 'status')->dropDownList([ 'active' => 'Active', 'suspend' => 'Suspend', ], ['prompt' => 'สถานะ']) ?>

    <div class="form-group">
        <?= Html::submitButton(' บันทึก', ['class' => 'btn btn-success fa fa-save']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
