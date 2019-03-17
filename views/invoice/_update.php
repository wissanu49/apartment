<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Invoice */
/* @var $form yii\widgets\ActiveForm */


$this->title = Yii::$app->name . ' : แก้ไขใบแจ้งหนี้';

$dateCreate = date('Y-m-d H:i:s');

foreach ($customer as $cus) {
    $cus_name = $cus['fullname'];
    $cus_addr = $cus['address'];
}
if ($customer2 != NULL) {
    foreach ($customer2 as $cus2) {
        $cus_name2 = $cus2['fullname'];
        $cus_addr2 = $cus2['address'];
    }
} else {
    $cus_name2 = NULL;
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
$company = \app\models\Company::find()->all();
foreach ($company as $comp) {
    $comp_name = $comp['company_name'];
    $comp_addr = $comp['address'];
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


                <div class="row">
                    <div class="col-xs-12 table-responsive">
                        <div class="row">

                            <div class="col-lg-6" style="text-align: left;">
                                <h4><?= $building_name ?></h4>
                                <h5><?= $building_addr ?></h5>
                            </div>
                            <div class="col-lg-6" style="text-align: right;">
                                <h4>ใบแจ้งหนี้</h4>
                                <b>เลขที่ : </b><?= $model->id ?>
                            </div>


                        </div>
                        <div class="row">
                            <div class="col-xs-6">

                                <h4>หมายเลขห้อง : <?= \app\models\Rooms::getRoomname($model->rooms_id) ?></h4>
                                <b>ผู้เช่า 1 : </b><?= $cus_name ?><br>
                                <b>ผู้เช่า 2 : </b><?= $cus_name2 ?>
                            </div>


                        </div>
                        <table class="table table-striped">
                            <tr>
                                <th style="width: 50%;">รายการ</th>
                                <th style="width: 30%;">จำนวนเงิน</th>
                            </tr>
                            <tbody>
                                <tr>
                                    <td>ค่าห้องพัก</td>
                                    <td>
                                        <?= $form->field($model, 'rental')->textInput()->label(false) ?>
                                    </td>
                                </tr>
                                <?php if ($model->deposit > 0) { ?>
                                    <tr>
                                        <td>ค่าประกันห้อง</td>
                                        <td>
                                            <?= $form->field($model, 'deposit')->textInput()->label(false) ?>
                                        </td>
                                    </tr>
                                <?php } else { ?>
                                    <?= $form->field($model, 'deposit')->hiddenInput()->label(false) ?>
                                <?php } ?>
                                <?php if ($model->electric_price > 0) { ?>
                                    <tr>
                                        <td>ค่าไฟฟ้า</td>
                                        <td><?= $form->field($model, 'electric_price')->textInput()->label(false) ?></td>
                                    </tr>
                                <?php } else { ?>
                                    <?= $form->field($model, 'electric_price')->hiddenInput()->label(false) ?>
                                <?php } ?>
                                <?php if ($model->water_price > 0) { ?>
                                    <tr>
                                        <td>ค่าน้ำปะปา</td>
                                        <td><?= $form->field($model, 'water_price')->textInput()->label(false) ?></td>
                                    </tr>
                                <?php } else { ?>
                                    <?= $form->field($model, 'water_price')->hiddenInput()->label(false) ?>
                                <?php } ?>
                                <tr>
                                    <td><?= $form->field($model, 'additional_1')->textInput(['placeholder' => 'ค่าใช้จ่านอื่น ๆ'])->label(false) ?></td>
                                    <td><?= $form->field($model, 'additional_1_price')->textInput()->label(false) ?></td>
                                </tr>
                                <tr>
                                    <td><?= $form->field($model, 'additional_2')->textInput(['placeholder' => 'ค่าใช้จ่านอื่น ๆ'])->label(false) ?></td>
                                    <td><?= $form->field($model, 'additional_2_price')->textInput()->label(false) ?></td>
                                </tr>
                                <tr>
                                    <td><?= $form->field($model, 'additional_3')->textInput(['placeholder' => 'ค่าใช้จ่านอื่น ๆ'])->label(false) ?></td>
                                    <td><?= $form->field($model, 'additional_3_price')->textInput()->label(false) ?></td>
                                </tr>
                                <tr>
                                    <td><?= $form->field($model, 'additional_4')->textInput(['placeholder' => 'ค่าใช้จ่านอื่น ๆ'])->label(false) ?></td>
                                    <td><?= $form->field($model, 'additional_4_price')->textInput()->label(false) ?></td>
                                </tr>
                                <tr>
                                    <td><?= $form->field($model, 'additional_5')->textInput(['placeholder' => 'ค่าใช้จ่านอื่น ๆ'])->label(false) ?></td>
                                    <td><?= $form->field($model, 'additional_5_price')->textInput()->label(false) ?></td>
                                </tr>
                                <tr>
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

                        <?= $form->field($model, 'status')->hiddenInput(['value' => 'รอการชำระ'])->label(false) ?>

                        <?= $form->field($model, 'users_id')->hiddenInput(['value' => Yii::$app->user->identity->id])->label(false) ?>

                        <?= $form->field($model, 'invoice_date')->hiddenInput(['value' => $dateCreate])->label(false) ?>

                        <div class="form-group">
                            <?= Html::submitButton(' บันทึก', ['class' => 'btn btn-success fa fa-save']) ?>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>



                <?php // $form->field($model, 'id')->textInput(['maxlength' => true, 'readonly' => 'readonly'])      ?>


                <?php //$form->field($model, 'total')->textInput()    ?>



                <?php ActiveForm::end(); ?>

            </div>
            <?php
            $this->RegisterJs("
    $('document').ready(function(){
        
        TotalCal();
        $('#" . Html::getInputId($model, 'deposit') . "').change(function(e){ 
            deposit = parseFloat($('#" . Html::getInputId($model, 'deposit') . "').val());
           if(isNaN(deposit)){
                $('#" . Html::getInputId($model, 'deposit') . "').val(0); 
            }
           TotalCal();
        });
        $('#" . Html::getInputId($model, 'rental') . "').change(function(e){ 
            rental = parseFloat($('#" . Html::getInputId($model, 'rental') . "').val());
           if(isNaN(rental)){
                $('#" . Html::getInputId($model, 'rental') . "').val(0); 
            }
           TotalCal();
        });
        $('#" . Html::getInputId($model, 'electric_price') . "').change(function(e){ 
            electric_price = parseFloat($('#" . Html::getInputId($model, 'electric_price') . "').val());
           if(isNaN(electric_price)){
                $('#" . Html::getInputId($model, 'electric_price') . "').val(0); 
            }
           TotalCal();
        });
        $('#" . Html::getInputId($model, 'water_price') . "').change(function(e){ 
            water_price = parseFloat($('#" . Html::getInputId($model, 'water_price') . "').val());
           if(isNaN(water_price)){
                $('#" . Html::getInputId($model, 'water_price') . "').val(0); 
            }
           TotalCal();
        });
        
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
        
        $('#" . Html::getInputId($model, 'water_unit_from') . "').change(function(e){ 
           WaterCal();
        });
        $('#" . Html::getInputId($model, 'water_unit_to') . "').change(function(e){ 
           WaterCal();
        });
        $('#" . Html::getInputId($model, 'electric_unit_from') . "').change(function(e){ 
           ElectricCal();
        });
        $('#" . Html::getInputId($model, 'electric_unit_to') . "').change(function(e){ 
           ElectricCal();
        });
         
        function WaterCal(){
            var unit_from;
            var unit_to;
            var total = 0;
            var price = 0;
            
            unit_from = parseFloat($('#" . Html::getInputId($model, 'water_unit_from') . "').val());
            unit_to = parseFloat($('#" . Html::getInputId($model, 'water_unit_to') . "').val());
                
            if(!isNaN(unit_from) && !isNaN(unit_to)){
                total = unit_to - unit_from;
            }
            
            price = total * " . $water . "
            
            $('#" . Html::getInputId($model, 'water_unit_total') . "').val(total);
            $('#" . Html::getInputId($model, 'water_price') . "').val(price);  
            TotalCal();   
        }
        
        function ElectricCal(){
            var unit_from;
            var unit_to;
            var total = 0;
            var price = 0;
            
            unit_from = parseFloat($('#" . Html::getInputId($model, 'electric_unit_from') . "').val());
            unit_to = parseFloat($('#" . Html::getInputId($model, 'electric_unit_to') . "').val());
                
            if(!isNaN(unit_from) && !isNaN(unit_to)){
                total = unit_to - unit_from;
            }
            
            price = total * " . $electric . "
             $('#" . Html::getInputId($model, 'electric_unit_total') . "').val(total);
            $('#" . Html::getInputId($model, 'electric_price') . "').val(price);  
            TotalCal();   
        }

        function TotalCal(){
            var amount = 0;
            var room = 0;
            var deposit = 0;
            var water_price = 0;
            var electric_price = 0;
            var a1 = 0;
            var a2 = 0;
            var a3 = 0;
            var a4 = 0;
            var a5 = 0;
            var total = 0;
            
            amount = parseFloat($('#" . Html::getInputId($model, 'total') . "').val());
            room = parseFloat($('#" . Html::getInputId($model, 'rental') . "').val());
            deposit = parseFloat($('#" . Html::getInputId($model, 'deposit') . "').val());
            water_price = parseFloat($('#" . Html::getInputId($model, 'water_price') . "').val());
            electric_price = parseFloat($('#" . Html::getInputId($model, 'electric_price') . "').val());
            a1 = parseFloat($('#" . Html::getInputId($model, 'additional_1_price') . "').val());
            a2 = parseFloat($('#" . Html::getInputId($model, 'additional_2_price') . "').val());
            a3 = parseFloat($('#" . Html::getInputId($model, 'additional_3_price') . "').val());
            a4 = parseFloat($('#" . Html::getInputId($model, 'additional_4_price') . "').val());
            a5 = parseFloat($('#" . Html::getInputId($model, 'additional_5_price') . "').val());
            
            if(!isNaN(deposit) && deposit.length != 0){
                total += deposit;
            }
            if(!isNaN(water_price) && water_price.length != 0){
                total += water_price;
            }
            if(!isNaN(electric_price) && electric_price.length != 0){
                total += electric_price;
            }
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
            
            total += room;          
            $('#" . Html::getInputId($model, 'total') . "').val(total);  
        }
        
    });

    ");
            ?>
        </div>
    </div>
</div>
