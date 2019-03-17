<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EnergiesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'ประวัติการบันทึก ห้อง '.$roomname;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header">
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-lg-12">
                <div class="table" >
                    <table class="table table-bordered" style="width: 100%;">
                        <tr>
                            <th>#</th>
                            <th style="width : 40%;">รอบเดือน</th>
                            <th  style="width : 20%;">หน่วยไฟฟ้า</th>
                            <th  style="width : 20%;">หน่วยปะปา</th>
                            <td></td>        
                        </tr>
                        <?php
                        $i = 1;
                        foreach ($dataProvider as $data) {
                            ?>
                            <tr>
                                <td><?= $i ?></td>
                                <td><?= Yii::$app->formatter->asDate($data['peroid']) ?></td>
                                <td><?= $data['electric_unit'] ?></td>
                                <td><?= $data['water_unit'] ?></td>
                                <td><?= Html::a(' แก้ไข', ['energies/update', 'id' => $data->id],[
                                            'class' => 'btn btn-warning fa fa-edit',]) ?></td>
                            </tr>
                        <?php $i++; } ?>
                    </table>
                </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
