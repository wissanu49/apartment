<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\Models\SearchInvoice */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="invoice-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'leasing_id') ?>

    <?= $form->field($model, 'room_price') ?>

    <?= $form->field($model, 'electric_unit') ?>

    <?= $form->field($model, 'electric_price') ?>

    <?php // echo $form->field($model, 'water_unit') ?>

    <?php // echo $form->field($model, 'water_price') ?>

    <?php // echo $form->field($model, 'additional_1') ?>

    <?php // echo $form->field($model, 'additional_1_price') ?>

    <?php // echo $form->field($model, 'additional_2') ?>

    <?php // echo $form->field($model, 'additional_2_price') ?>

    <?php // echo $form->field($model, 'additional_3') ?>

    <?php // echo $form->field($model, 'additional_3_price') ?>

    <?php // echo $form->field($model, 'additional_4') ?>

    <?php // echo $form->field($model, 'additional_4_price') ?>

    <?php // echo $form->field($model, 'additional_5') ?>

    <?php // echo $form->field($model, 'additional_5_price') ?>

    <?php // echo $form->field($model, 'refun_1') ?>

    <?php // echo $form->field($model, 'refun_1_price') ?>

    <?php // echo $form->field($model, 'refun_2') ?>

    <?php // echo $form->field($model, 'refun_2_price') ?>

    <?php // echo $form->field($model, 'total') ?>

    <?php // echo $form->field($model, 'comment') ?>

    <?php // echo $form->field($model, 'appointment') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'users_id') ?>

    <?php // echo $form->field($model, 'invoice_date') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
