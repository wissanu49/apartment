<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Building */

$this->title = 'เพิ่ม ตึก/อาคาร';
$this->params['breadcrumbs'][] = ['label' => 'ตึก/อาคาร', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

