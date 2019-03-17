<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Energies */

$this->title = 'แก้ไขหน่าวยไฟฟ้า/ปะปา : ' . $model->rooms->name;
$this->params['breadcrumbs'][] = ['label' => 'หน่าวยไฟฟ้า/ปะปา', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="row">
    <div class="col-xs-3"></div>
    <div class="col-xs-6">
        <div class="box">
            <div class="box-header">
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <?=
                $this->render('_form', [
                    'model' => $model,
                ])
                ?>

            </div>
        </div>
    </div>
    <div class="col-xs-3"></div>
</div>
