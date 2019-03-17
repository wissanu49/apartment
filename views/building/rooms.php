<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$this->title = 'ตึก/อาคาร/ห้องพัก';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
Modal::begin([
    'headerOptions' => ['id' => 'modalHeader'],
    'id' => 'modal',
    'size' => 'modal-lg',
]);
echo "<div id='modalContent'></div>";
Modal::end();
?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">ตึก/อาคาร : <?= app\models\Building::getBuildingName($id) ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table class="table table-bordered table-hover">
                    <thead>
                    <th>ห้อง</th>
                    <th>ราคาต่อดือน</th>
                    <th>ประเภท</th>
                    <th>หน่วยไฟฟ้า/ปะปา</th>
                    <th>สถานะ</th>
                    <th></th>
                    </thead>
                    <?php
                    foreach ($dataProvider as $data) {
                        ?>
                        <tr>
                            <td><?= $data->name ?></td>
                            <td><?= $data->monthly_price ?></td>
                            <td><?= $data->type ?></td>
                            <td>
                                <?=
                                Html::button(' บันทึกหน่วยไฟฟ้า/ปะปา', ['value' => Url::to(['energies/create', 'room' => $data->id]),
                                    'title' => 'บันทึกหน่วยไฟฟ้า/ปะปา : ' . $data['name'],
                                    'id' => 'showModalButton',
                                    'class' => 'btn btn-info fa fa-flash'
                                ]) . " " .
                                Html::button(' รายการบันทึกทั้งหมด', ['value' => Url::to(['energies/histories', 'room' => $data['id']]),
                                    'title' => 'รายการบันทึกทั้งหมด : ' . $data['name'],
                                    'id' => 'showModalButton',
                                    'class' => 'btn btn-warning fa fa-database'
                                ]);
                                ?>
                            </td>
                            <td>
                                <?=
                                Html::a(' ว่าง ', NULL, ['title' => 'สถานะ : ว่าง',
                                    //'id' => 'showModalButton',
                                    'class' => 'btn btn-success',
                                    'disabled' => true,
                                ]);
                                ?>
                                <?=
                                Html::button(' ย้ายเข้า', ['value' => Url::to(['rooms/update', 'id' => $data->id]),
                                    'title' => 'ย้ายเข้า : ' . $data->name,
                                    'id' => 'showModalButton',
                                    'class' => 'btn btn-primary fa fa-edit'
                                ]);
                                ?>
                            </td>
                            <td>
                                <?=
                                Html::button('', ['value' => Url::to(['rooms/update', 'id' => $data->id]),
                                    'title' => 'แก้ไขข้อมูล : ' . $data->name,
                                    'id' => 'showModalButton',
                                    'class' => 'btn btn-primary fa fa-edit'
                                ]);
                                ?>
                            </td>
                        </tr>
<?php } ?>
                </table>
            </div>
        </div>
    </div>
</div> 
