<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Receipt */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="receipt-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'leasing_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rental')->textInput() ?>

    <?= $form->field($model, 'electric_price')->textInput() ?>

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

    <?= $form->field($model, 'invoice_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'users_id')->textInput() ?>

    <?= $form->field($model, 'receipt_date')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
