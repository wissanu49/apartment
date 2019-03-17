<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Customers */

$this->title = 'แก้ไขข้อมูล : ' . $model->fullname;
$this->params['breadcrumbs'][] = ['label' => 'ฐานข้อมูลลูกค้า', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'แก้ไขข้อมูล';
?>
    <div class="row">
        <div class="col-lg-12 col-xs-12 col-md-12">
            <?=
            $this->render('_form', [
                'model' => $model,
            ])
            ?>
        </div>

    </div>

