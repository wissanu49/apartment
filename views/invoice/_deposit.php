<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Invoice */
/* @var $form yii\widgets\ActiveForm */
$dataOption = [
    'ค่าประกันห้อง (Deposit)' => 'ค่าประกันห้อง (Deposit)',
    'ค่าส่วนกลาง (Facility)' => 'ค่าส่วนกลาง (Facility)',
    'ค่าโทรศัพท์ (Telephone)' => 'ค่าโทรศัพท์ (Telephone)',
    'ค่าเคเบิลทีวี (Cable TV)' => 'ค่าเคเบิลทีวี (Cable TV)',
    'ค่าปรับ (Penalty fee)' => 'ค่าปรับ (Penalty fee)',
    'ค่าซ่อมบำรุง (Maintenance)' => 'ค่าซ่อมบำรุง (Maintenance)',
    'ค่าซ่อมบำรุง (Maintenance)' => 'ค่าซ่อมบำรุง (Maintenance)',
    'ค่าเช่าเฟอร์นิเจอร์ (Furniture)' => 'ค่าเช่าเฟอร์นิเจอร์ (Furniture)',
    'ค่าบริการ (Service)' => 'ค่าบริการ (Service)',
    'ค้างจ่าย (Arrears)' => 'ค้างจ่าย (Arrears)',
];

$this->title = Yii::$app->name.' : ออกใบแจ้งหนี้';

$dateCreate = date('Y-m-d H:i:s');

foreach ($customer as $cus) {
    $cus_name = $cus['fullname'];
}
if ($customer2 == NULL) {
    $cus_name2 = NULL;
} else {
    foreach ($customer2 as $cus2) {
        $cus_name2 = $cus2['fullname'];
    }
}
foreach ($config as $cfg) {
    $electric = $cfg['electric'];
    $water = $cfg['water'];
}
$building = \app\models\Building::getBuilding($model->rooms_id);
foreach ($building as $build) {
    $building_name = $build['building_name'];
    $building_addr = $build['building_address'];
}
?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <?php $form = ActiveForm::begin(); ?>
                <!-- Table row -->
                <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
                <?= $form->field($model, 'leasing_id')->hiddenInput()->label(false) ?>
                 <?= $form->field($model, 'rooms_id')->hiddenInput()->label(false) ?>
                 <?= $form->field($model, 'electric_unit')->hiddenInput(['value'=>0])->label(false) ?>
                 <?= $form->field($model, 'electric_price')->hiddenInput(['value'=>0])->label(false) ?>
                 <?= $form->field($model, 'water_unit')->hiddenInput(['value'=>0])->label(false) ?>
                 <?= $form->field($model, 'water_price')->hiddenInput(['value'=>0])->label(false) ?>
                <?php
                foreach ($customer as $cus) {
                    $cus_name = $cus['fullname'];
                    $cus_addr = $cus['address'];
                }
                ?>

                <div class="row">
                    <div class="col-xs-8 table-responsive">
                        <div class="row">

                            <div class="col-lg-6" style="text-align: left;">
                                <h4><?= $building_name ?></h4>
                                <h6><?= $building_addr ?></h6>
                            </div>
                            <div class="col-lg-6" style="text-align: right;">
                                <h4>ใบแจ้งหนี้</h4>
                                <b>เลขที่ : </b><?= $model->id ?>
                            </div>
                            

                        </div>
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6">
                               
                                <h4>สัญญาเช่า : <?= $model->leasing_id; ?> ห้อง : <?= \app\models\Rooms::getRoomname($room) ?></h4>
                                <b>ผู้เช่า 1 : </b><?= $cus_name ?><br>
                                <b>ผู้เช่า 2 : </b><?= $cus_name2 ?>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6">
                                <h3 style="text-align: right;"><b>ห้อง : </b><?= \app\models\Rooms::showName($room); ?></h3>
                            </div>

                        </div>
                        <table class="table table-striped">
                            <tr>
                                <th style="width: 10%;">#</th>
                                <th style="width: 50%;">รายการ</th>
                                <th style="width: 30%;">จำนวนเงิน</th>
                            </tr>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>ค่าห้องพัก</td>
                                    <td>
                                        <?= $form->field($model, 'rental')->textInput(['readonly' => 'readonly'])->label(false) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>ค่าประกันห้อง</td>
                                    <td>
                                        <?= $form->field($model, 'deposit')->textInput(['readonly' => 'readonly'])->label(false) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td><?= $form->field($model, 'additional_1')->textInput(['placeholder' => 'ค่าใช้จ่านอื่น ๆ'])->label(false) ?></td>
                                    <td><?= $form->field($model, 'additional_1_price')->textInput()->label(false) ?></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td><?= $form->field($model, 'additional_2')->textInput(['placeholder' => 'ค่าใช้จ่านอื่น ๆ'])->label(false) ?></td>
                                    <td><?= $form->field($model, 'additional_2_price')->textInput()->label(false) ?></td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td><?= $form->field($model, 'additional_3')->textInput(['placeholder' => 'ค่าใช้จ่านอื่น ๆ'])->label(false) ?></td>
                                    <td><?= $form->field($model, 'additional_3_price')->textInput()->label(false) ?></td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td><?= $form->field($model, 'additional_4')->textInput(['placeholder' => 'ค่าใช้จ่านอื่น ๆ'])->label(false) ?></td>
                                    <td><?= $form->field($model, 'additional_4_price')->textInput()->label(false) ?></td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td><?= $form->field($model, 'additional_5')->textInput(['placeholder' => 'ค่าใช้จ่านอื่น ๆ'])->label(false) ?></td>
                                    <td><?= $form->field($model, 'additional_5_price')->textInput()->label(false) ?></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td style="text-align: right; font-size: 16px;"><b>ราคารวม</b></td>
                                    <?php
                                    $total = $model->rental + $model->deposit;
                                    ?>
                                    <td><?= $form->field($model, 'total')->textInput(['value' => $total, 'readonly' => 'readonly'])->label(false) ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="col-lg-6">
                            <?=
                            $form->field($model, 'appointment')->widget(Datepicker::className(), [
                                'template' => '{input}{addon}',
                                'options' => ['placeholder' => 'วันกำหนดชำระ'],
                                'value' => NULL,
                                'language' => 'th',
                                'clientOptions' => [
                                    'autoclose' => true,
                                    'format' => 'yyyy-mm-dd',
                                    'todayHighlight' => true,
                                ]
                            ])
                            ?>
                        </div>
                        <div class="col-lg-6">
                            <?= $form->field($model, 'comment')->textarea(['rows' => 5]) ?>
                        </div>

                        <?=$form->field($model, 'status')->hiddenInput(['value' => 'รอการชำระ'])->label(false) ?>

                        <?= $form->field($model, 'users_id')->hiddenInput(['value' => Yii::$app->user->identity->id])->label(false) ?>

                        <?= $form->field($model, 'invoice_date')->hiddenInput(['value'=> $dateCreate])->label(false) ?>

                        <div class="form-group">
                            <?= Html::submitButton(' บันทึก', ['class' => 'btn btn-success fa fa-save']) ?>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>



                <?php // $form->field($model, 'id')->textInput(['maxlength' => true, 'readonly' => 'readonly'])    ?>


                <?php //$form->field($model, 'total')->textInput()  ?>



                <?php ActiveForm::end(); ?>

            </div>
            <?php
            $this->RegisterJs("
    $('document').ready(function(){
          
        $('#" . Html::getInputId($model, 'additional_1_price') . "').change(function(e){ 
           TotalCal();
        });
        $('#" . Html::getInputId($model, 'additional_2_price') . "').change(function(e){ 
           TotalCal();
        });
        $('#" . Html::getInputId($model, 'additional_3_price') . "').change(function(e){ 
           TotalCal();
        });
        $('#" . Html::getInputId($model, 'additional_4_price') . "').change(function(e){ 
           TotalCal();
        });
        $('#" . Html::getInputId($model, 'additional_5_price') . "').change(function(e){ 
           TotalCal();
        });
        

        function TotalCal(){
            var amount = 0;
            var room = 0;
            var deposit;
            var a1 = 0;
            var a2 = 0;
            var a3 = 0;
            var a4 = 0;
            var a5 = 0;
            var total = 0;
            
            amount = parseInt($('#" . Html::getInputId($model, 'total') . "').val());
            room = parseInt($('#" . Html::getInputId($model, 'rental') . "').val());
            deposit = parseInt($('#" . Html::getInputId($model, 'deposit') . "').val());
            a1 = parseInt($('#" . Html::getInputId($model, 'additional_1_price') . "').val());
            a2 = parseInt($('#" . Html::getInputId($model, 'additional_2_price') . "').val());
            a3 = parseInt($('#" . Html::getInputId($model, 'additional_3_price') . "').val());
            a4 = parseInt($('#" . Html::getInputId($model, 'additional_4_price') . "').val());
            a5 = parseInt($('#" . Html::getInputId($model, 'additional_5_price') . "').val());
            
            if(!isNaN(a1) && a1.length != 0){
                total += a1;
            }
            if(!isNaN(a2) && a2.length != 0){
                total += a2;
            }
            if(!isNaN(a3) && a3.length != 0){
                total += a3;
            }
            if(!isNaN(a4) && a4.length != 0){
                total += a4;
            }
            if(!isNaN(a5) && a5.length != 0){
                total += a5;
            }
            
            total += (room + deposit);          
            $('#" . Html::getInputId($model, 'total') . "').val(total);  
        }
        
    });

    ");
            ?>
        </div>
    </div>
</div>
