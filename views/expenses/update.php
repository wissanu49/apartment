<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Expenses */

$this->title = 'แก้ไขรายการ: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'ค่าใช้จ่าย', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="expenses-update">


    <?= $this->render('_update', [
        'model' => $model,
    ]) ?>

</div>
