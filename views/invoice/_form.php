<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Invoice */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="invoice-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'leasing_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'room_price')->textInput() ?>

    <?= $form->field($model, 'electric_unit')->textInput() ?>

    <?= $form->field($model, 'electric_price')->textInput() ?>

    <?= $form->field($model, 'water_unit')->textInput() ?>

    <?= $form->field($model, 'water_price')->textInput() ?>

    <?= $form->field($model, 'additional_1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'additional_1_price')->textInput() ?>

    <?= $form->field($model, 'additional_2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'additional_2_price')->textInput() ?>

    <?= $form->field($model, 'additional_3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'additional_3_price')->textInput() ?>

    <?= $form->field($model, 'additional_4')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'additional_4_price')->textInput() ?>

    <?= $form->field($model, 'additional_5')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'additional_5_price')->textInput() ?>

    <?= $form->field($model, 'refun_1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'refun_1_price')->textInput() ?>

    <?= $form->field($model, 'refun_2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'refun_2_price')->textInput() ?>

    <?= $form->field($model, 'total')->textInput() ?>

    <?= $form->field($model, 'comment')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'appointment')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList([ 'waiting' => 'Waiting', 'payment' => 'Payment', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'users_id')->textInput() ?>

    <?= $form->field($model, 'invoice_date')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
