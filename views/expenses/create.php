<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Expenses */

$this->title = 'รายการค่าใช้จ่าย';
$this->params['breadcrumbs'][] = ['label' => 'ค่าใช้จ่าย', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="expenses-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
