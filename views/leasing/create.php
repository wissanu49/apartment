<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Leasing */

$this->title = Yii::$app->name.' : ทำสัญญาเช่า';
$this->params['breadcrumbs'][] = ['label' => 'สัญญาเช่า', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="box">
            <div class="box-header">
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="table-responsive">
                <?=
                $this->render('_form', [
                    'model' => $model,
                ])
                ?>
                </div>
            </div>
        </div>
    </div>
</div>

