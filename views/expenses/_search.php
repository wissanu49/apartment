<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\Models\SearchExpenses */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="expenses-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'expenses_1') ?>

    <?= $form->field($model, 'expenses_1_price') ?>

    <?= $form->field($model, 'expenses_2') ?>

    <?= $form->field($model, 'expenses_2_price') ?>

    <?php // echo $form->field($model, 'expenses_3') ?>

    <?php // echo $form->field($model, 'expenses_3_price') ?>

    <?php // echo $form->field($model, 'expenses_4') ?>

    <?php // echo $form->field($model, 'expenses_4_price') ?>

    <?php // echo $form->field($model, 'expenses_5') ?>

    <?php // echo $form->field($model, 'expenses_5_price') ?>

    <?php // echo $form->field($model, 'total') ?>

    <?php // echo $form->field($model, 'date_record') ?>

    <?php // echo $form->field($model, 'users_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
