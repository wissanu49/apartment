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

$this->title = Yii::$app->name . ' : ชำระเงิน';

$dateCreate = date('Y-m-d H:i:s');

$building = \app\models\Building::getBuilding($room);
foreach($building as $build){
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
                <?= $form->field($model, 'invoice_id')->hiddenInput()->label(false) ?>
                <?php
                foreach ($customer as $cus) {
                    $cus_name = $cus['fullname'];
                    $cus_addr = $cus['address'];
                }
                if($customer2 != NULL){
                foreach ($customer2 as $cus2) {
                    $cus_name2 = $cus2['fullname'];
                    $cus_addr2 = $cus2['address'];
                }
                }else{
                    $cus_name2 = NULL;
                }
                ?>

                <div class="row">
                    <div class="col-xs-8 table-responsive">
                        <div class="row">

                            <div class="col-lg-6" style="text-align: left;">
                                <h4><?= $building_name ?></h4>
                                <h5><?= $building_addr ?></h5>
                            </div>
                            <div class="col-lg-6" style="text-align: right;">
                                <h4>ใบแจ้งหนี้</h4>
                                <b>เลขที่ : </b><?= $model->invoice_id ?>
                            </div>


                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <b>หมายเลขห้อง : </b><?= \app\models\Rooms::showName($room); ?>
                                <br>
                                <b>ผู้เช่า 1 : </b><?= $cus_name; ?><br>
                                <b>ผู้เช่า 2 : </b><?= $cus_name2; ?>
                            </div>
                            <div class="col-xs-6" style="text-align: right;">
                                <br>
                                <b>วันที่ออกบิล : </b><?= Yii::$app->formatter->asDate($invoice_date) ?>
                                <br>
                                <b>ชำระก่อนวันที่ : </b><?= Yii::$app->formatter->asDate($appointment) ?>
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
                                    <td style="text-align: center;"><h4>การคืนเงิน</h4></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><?= $form->field($model, 'refun_1')->textInput(['readonly'=>'readonly'])->label(false) ?></td>
                                    <td><?= $form->field($model, 'refun_1_price')->textInput(['readonly'=>'readonly'])->label(false) ?></td>
                                </tr>
                                <tr>
                                    <td><?= $form->field($model, 'refun_2')->textInput(['placeholder' => 'คืนเงิน'])->label(false) ?></td>
                                    <td><?= $form->field($model, 'refun_2_price')->textInput()->label(false) ?></td>
                                </tr>
                                <tr>
                                    <td style="text-align: right; font-size: 16px;"><b>ราคารวม</b></td>
                                    <?php
                                    //$total = $model->rental + $model->deposit;
                                    ?>
                                    <td><?= $form->field($model, 'total')->textInput(['readonly' => 'readonly'])->label(false) ?></td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="col-lg-12">
                            <?= $form->field($model, 'comment')->textarea(['rows' => 5]) ?>
                        </div>


                        <?= $form->field($model, 'users_id')->hiddenInput(['value' => Yii::$app->user->identity->id])->label(false) ?>

                        <?= $form->field($model, 'receipt_date')->hiddenInput(['value' => $dateCreate])->label(false) ?>

                        <div class="form-group">
                            <?= Html::submitButton(' ชำระเงิน', ['class' => 'btn btn-success fa fa-save']) ?>
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
    
        TotalCal();
          
         $('#" . Html::getInputId($model, 'rental') . "').change(function(e){ 
           room = parseFloat($('#" . Html::getInputId($model, 'rental') . "').val());
           if(isNaN(room)){
            $('#" . Html::getInputId($model, 'room') . "').val(0);
            }
           TotalCal();
        });
        $('#" . Html::getInputId($model, 'deposit') . "').change(function(e){ 
            deposit = parseFloat($('#" . Html::getInputId($model, 'deposit') . "').val());  
                 if(isNaN(deposit)){
            $('#" . Html::getInputId($model, 'deposit') . "').val(0);
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
        
        $('#" . Html::getInputId($model, 'refun_1_price') . "').change(function(e){ 
           TotalCal();
        });
        $('#" . Html::getInputId($model, 'refun_2_price') . "').change(function(e){ 
           TotalCal();
        });
        

        function TotalCal(){
            var amount = 0;
            var room = 0;
            var deposit = 0;
            var electric = 0;
            var water = 0;
            var a1 = 0;
            var a2 = 0;
            var a3 = 0;
            var a4 = 0;
            var a5 = 0;
            var refun1 = 0;
            var refun2 = 0;
            var total = 0;
            var total_refun = 0;
            
            amount = parseFloat($('#" . Html::getInputId($model, 'total') . "').val());
            room = parseFloat($('#" . Html::getInputId($model, 'rental') . "').val());
            deposit = parseFloat($('#" . Html::getInputId($model, 'deposit') . "').val());
            electric = parseFloat($('#" . Html::getInputId($model, 'electric_price') . "').val());
            water = parseFloat($('#" . Html::getInputId($model, 'water_price') . "').val());
            a1 = parseFloat($('#" . Html::getInputId($model, 'additional_1_price') . "').val());
            a2 = parseFloat($('#" . Html::getInputId($model, 'additional_2_price') . "').val());
            a3 = parseFloat($('#" . Html::getInputId($model, 'additional_3_price') . "').val());
            a4 = parseFloat($('#" . Html::getInputId($model, 'additional_4_price') . "').val());
            a5 = parseFloat($('#" . Html::getInputId($model, 'additional_5_price') . "').val());
            refun1 = parseFloat($('#" . Html::getInputId($model, 'refun_1_price') . "').val());
            refun2 = parseFloat($('#" . Html::getInputId($model, 'refun_2_price') . "').val());
            
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
            if(!isNaN(electric) && electric.length != 0){
                total += electric;
            }
            if(!isNaN(water) && water.length != 0){
                total += water;
            }
            if(!isNaN(refun1) && refun1.length != 0){
                total_refun += refun1;
            }
            if(!isNaN(refun2) && refun2.length != 0){
                total_refun += refun2;
            }
            
            total = total + (room + deposit);      
            total = total - total_refun;
            $('#" . Html::getInputId($model, 'total') . "').val(total);  
        }
        
    });

    ");
            ?>
        </div>
    </div>
</div>
