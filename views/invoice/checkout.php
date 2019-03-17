<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Invoice */
/* @var $form yii\widgets\ActiveForm */


$this->title = 'ออกใบแจ้งหนี้';

$dateCreate = date('Y-m-d H:i:s');

foreach ($customer as $cus) {
    $cus_name = $cus['fullname'];
    $cus_addr = $cus['address'];
}

foreach ($config as $cfg){
    $electric = $cfg['electric'];
    $water = $cfg['water'];
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
                <?= $form->field($model, 'rooms_id')->hiddenInput(['value' => $room])->label(false) ?>


                <div class="row">
                    <div class="col-xs-12 table-responsive">
                        <div class="row">

                            <div class="col-lg-6" style="text-align: left;">
                                <h4>LYMRR</h4>
                            </div>
                            <div class="col-lg-6" style="text-align: right;">
                                <h4>ใบแจ้งหนี้</h4>
                                <b>เลขที่ : </b><?= $model->id ?>
                            </div>


                        </div>
                        <div class="row">
                            <div class="col-xs-6">

                                <b>สัญญาเช่า : </b><?= $model->leasing_id; ?>
                                <br>
                                <b>ลูกค้า : </b><?= $cus_name; ?><br>
                                <b>ที่อยู่ : </b><?= $cus_addr; ?>
                            </div>
                            <div class="col-xs-6" style="text-align: right;">
                                <h3>ห้อง : <?= \app\models\Rooms::showName($room); ?></h3>
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
                                <tr>
                                    <td>
                                        <table>
                                            <tr>
                                                <td colspan="3">
                                                    หน่วยไฟฟ้าที่ใช้งาน [ หน่วยละ <?= $electric ?> บาท]
                                                </td>
                                                <td>รวม</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <?=
                                                    $form->field($model, 'electric_unit_to')->dropDownList(ArrayHelper::map(app\models\Energies::getElectric($room), 'electric_unit', function ($data) {
                                                                return Yii::$app->formatter->asDate($data['peroid']) . ' [' . $data['electric_unit'] . ']';
                                                            }))->label(false)
                                                    ?>
                                                </td>
                                                <td style="width: 10%; text-align: center;"> - </td>
                                                <td>
                                                    <?=
                                                    $form->field($model, 'electric_unit_from')->dropDownList(ArrayHelper::map(array_reverse(app\models\Energies::getElectric($room)), 'electric_unit', function ($data) {
                                                                return Yii::$app->formatter->asDate($data['peroid']) . ' [' . $data['electric_unit'] . ']';
                                                            }))->label(false)
                                                    ?>
                                                </td>
                                                <td style="width: 20%;">
                                                    <div class="form-group">

                                                        <?= Html::textInput('', '', ['id' => 'invoice-electric_unit_total', 'class' => 'form-control', 'readonly' => 'readonly']) ?>
                                                    </div>
                                                </td>

                                            </tr>


                                        </table>


                                    </td>
                                    <td style="vertical-align: bottom;"><?= $form->field($model, 'electric_price')->textInput()->label(false) ?></td>
                                </tr>
                                <tr>
                                    <td>
                                        <table>
                                            <tr>
                                                <td colspan="3">
                                                    หน่วยน้ำปะปาที่ใช้งาน [ หน่วยละ <?= $water ?> บาท ]
                                                </td>
                                                <td>รวม</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <?=
                                                    $form->field($model, 'water_unit_to')->dropDownList(ArrayHelper::map(app\models\Energies::getWater($room), 'water_unit', function ($model) {
                                                                if($model['water_unit'] != NULL){
                                                                    return Yii::$app->formatter->asDate($model['peroid']) . ' [' . $model['water_unit'] . ']';
                                                                }                                                        
                                                            }))->label(false)
                                                    ?>
                                                </td>
                                                <td style="width: 10%; text-align: center;"> - </td>
                                                <td>
                                                    <?=
                                                    $form->field($model, 'water_unit_from')->dropDownList(ArrayHelper::map(array_reverse(app\models\Energies::getWater($room)), 'water_unit', function ($model) {
                                                                return Yii::$app->formatter->asDate($model['peroid']) . ' [' . $model['water_unit'] . ']';
                                                            }))->label(false)
                                                    ?>
                                                </td>  
                                                <td style="width: 20%;">
                                                    <div class="form-group">
                                                        <?= Html::textInput('', '', ['id' => 'invoice-water_unit_total', 'class' => 'form-control', 'readonly' => 'readonly']) ?>
                                                    </div>
                                                </td>
                                            </tr>    
                                        </table>
                                    </td>
                                    <td style="vertical-align: bottom;"><?= $form->field($model, 'water_price')->textInput()->label(false) ?></td>
                                </tr>
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
                                    <td><?= $form->field($model, 'refun_1')->textInput(['value' => 'คืนค่าประกันห้อง','readonly'=>'readonly'])->label(false) ?></td>
                                    <td><?= $form->field($model, 'refun_1_price')->textInput(['value'=>$deposit,'readonly'=>'readonly'])->label(false) ?></td>
                                </tr>
                                <tr>
                                    <td><?= $form->field($model, 'refun_2')->textInput(['placeholder' => 'คืนเงิน'])->label(false) ?></td>
                                    <td><?= $form->field($model, 'refun_2_price')->textInput()->label(false) ?></td>
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
            $a = 10;
            $this->RegisterJs("
    $('document').ready(function(){
    
        WaterCal();
        ElectricCal();
        $('#" . Html::getInputId($model, 'rental') . "').change(function(e){ 
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
            
            unit_from = parseInt($('#" . Html::getInputId($model, 'water_unit_from') . "').val());
            unit_to = parseInt($('#" . Html::getInputId($model, 'water_unit_to') . "').val());
                
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
            
            unit_from = parseInt($('#" . Html::getInputId($model, 'electric_unit_from') . "').val());
            unit_to = parseInt($('#" . Html::getInputId($model, 'electric_unit_to') . "').val());
                
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
            var water_price = 0;
            var electric_price = 0;
            var a1 = 0;
            var a2 = 0;
            var a3 = 0;
            var a4 = 0;
            var a5 = 0;
            var refun1 = 0;
            var refun2 = 0;
            var total = 0;
            var total_refun = 0;
            
            amount = parseInt($('#" . Html::getInputId($model, 'total') . "').val());
            room = parseInt($('#" . Html::getInputId($model, 'rental') . "').val());
            water_price = parseInt($('#" . Html::getInputId($model, 'water_price') . "').val());
            electric_price = parseInt($('#" . Html::getInputId($model, 'electric_price') . "').val());
            a1 = parseInt($('#" . Html::getInputId($model, 'additional_1_price') . "').val());
            a2 = parseInt($('#" . Html::getInputId($model, 'additional_2_price') . "').val());
            a3 = parseInt($('#" . Html::getInputId($model, 'additional_3_price') . "').val());
            a4 = parseInt($('#" . Html::getInputId($model, 'additional_4_price') . "').val());
            a5 = parseInt($('#" . Html::getInputId($model, 'additional_5_price') . "').val());
            refun1 = parseInt($('#" . Html::getInputId($model, 'refun_1_price') . "').val());
            refun2 = parseInt($('#" . Html::getInputId($model, 'refun_2_price') . "').val());
            
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
            
            if(!isNaN(refun1) && refun1.length != 0){
                total_refun += refun1;
            }
            if(!isNaN(refun2) && refun2.length != 0){
                total_refun += refun2;
            }
            
                       
            total += room;              
            total = total - total_refun;
            $('#" . Html::getInputId($model, 'total') . "').val(total);  
        }
        
    });

    ");
            ?>
        </div>
    </div>
</div>
