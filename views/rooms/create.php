<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Rooms */

$this->title = 'เพิ่มห้องพัก';
$this->params['breadcrumbs'][] = ['label' => 'ห้องพัก', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>


