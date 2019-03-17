<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Leasing */
/* @var $form yii\widgets\ActiveForm */
$this->title = Yii::$app->name.' : ย้ายออก';
$dateCreate = date('Y-m-d H:i:s');

foreach ($customer as $cus) {
    $cus_name = $cus['fullname'];
    $cus_addr = $cus['address'];
}

foreach ($config as $cfg) {
    $electric = $cfg['electric'];
    $water = $cfg['water'];
}

foreach($owe as $owe_inv){
    $o_invid = $owe_inv['id'];
    $o_total = $owe_inv['total'];
}

?>
<?php
$form = ActiveForm::begin();
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="box">
            <div class="box-header">
            </div>
            <!-- /.box-header -->
            <div class="box-body">

                <div class="row">
                    <div class="col-sm-3 col-xs-3 col-lg-3">
                        <?= $form->field($model, 'id')->textInput(['maxlength' => true, 'disabled' => true]) ?>
                    </div>
                    <div class="col-sm-3 col-xs-3 col-lg-3">
                        <?=
                        $form->field($model, 'rooms_id')->dropDownList(
                                ArrayHelper::map(app\models\Rooms::find()->all(), 'id', 'name'), ['disabled' => true])
                        ?>
                    </div>
                    <div class="col-sm-3 col-xs-3 col-lg-3">
                        <?= $form->field($model, 'customers_id')->dropDownList(ArrayHelper::map(app\models\Customers::find()->select(['id', 'fullname'])->all(), 'id', 'fullname'), ['prompt' => 'เลือกผู้เช่า', 'disabled' => 'disabled']) ?>
                    </div>
                    <div class="col-sm-3 col-xs-3 col-lg-3">
                        <?=
                        $form->field($model, 'move_in')->widget(
                                DatePicker::className(), [
                            'template' => '{input}{addon}',
                            'options' => ['placeholder' => 'วันที่ย้ายออก', 'disabled' => 'disabled'],
                            'value' => date('Y-m-d'),
                            'language' => 'th',
                            'clientOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd',
                                'todayHighlight' => true,
                            ]
                        ]);
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2 col-xs-2 col-lg-2">
                       <?=
                $form->field($model, 'move_out')->widget(
                        DatePicker::className(), [
                    'template' => '{input}{addon}',
                    'options' => ['placeholder' => 'วันที่ย้ายออก'],
                    'value' => NULL,
                    'language' => 'th',
                    'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                        'todayHighlight' => true,
                    ]
                ]);
                ?>
                    </div>
                    <div class="col-sm-2 col-xs-2 col-lg-2">
                       <?= $form->field($model, 'status')->dropDownList(['OUT' => 'OUT']) ?>
                    </div>
                     <div class="col-sm-2 col-xs-2 col-lg-2">
                       <?= $form->field($model, 'deposit')->textInput(['value' => isset($model->rooms_id) ? $model->rooms->deposit : NULL, 'readonly' => 'readonly']) ?>
                    </div>
                    <div class="col-sm-6 col-xs-6 col-lg-6">
                        <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>
                    </div>
                   
                </div>

            </div>
        </div>
    </div>
    
    <div class="col-xs-2 col-sm-2 col-lg-2"></div>
    <div class="col-xs-8 col-sm-8 col-lg-8">
        <div class="box">
            <div class="box-header">
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <?php // $form = ActiveForm::begin(); ?>
                <!-- Table row -->
                <?= $form->field($invoice, 'id')->hiddenInput()->label(false) ?>
                <?= $form->field($invoice, 'leasing_id')->hiddenInput()->label(false) ?>
                <?= $form->field($invoice, 'rooms_id')->hiddenInput(['value' => $room])->label(false) ?>


                <div class="row">
                    <div class="col-xs-12 table-responsive">
                        <div class="row">

                            <div class="col-lg-6" style="text-align: left;">
                                <h4>LYMRR</h4>
                            </div>
                            <div class="col-lg-6" style="text-align: right;">
                                <h4>ใบแจ้งหนี้</h4>
                                <b>เลขที่ : </b><?= $invoice->id ?>
                            </div>


                        </div>
                        <div class="row">
                            <div class="col-xs-6">

                                <b>สัญญาเช่า : </b><?= $invoice->leasing_id; ?>
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
<?= $form->field($invoice, 'rental')->textInput()->label(false) ?>
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
                                                    $form->field($invoice, 'electric_unit_to')->dropDownList(ArrayHelper::map(app\models\Energies::getElectric($room), 'electric_unit', function ($data) {
                                                                return Yii::$app->formatter->asDate($data['peroid']) . ' [' . $data['electric_unit'] . ']';
                                                            }))->label(false)
                                                    ?>
                                                </td>
                                                <td style="width: 10%; text-align: center;"> - </td>
                                                <td>
                                                    <?=
                                                    $form->field($invoice, 'electric_unit_from')->dropDownList(ArrayHelper::map(array_reverse(app\models\Energies::getElectric($room)), 'electric_unit', function ($data) {
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
                                    <td style="vertical-align: bottom;"><?= $form->field($invoice, 'electric_price')->textInput()->label(false) ?></td>
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
                                                    $form->field($invoice, 'water_unit_to')->dropDownList(ArrayHelper::map(app\models\Energies::getWater($room), 'water_unit', function ($data) {
                                                                if ($data['water_unit'] != NULL) {
                                                                    return Yii::$app->formatter->asDate($data['peroid']) . ' [' . $data['water_unit'] . ']';
                                                                }
                                                            }))->label(false)
                                                    ?>
                                                </td>
                                                <td style="width: 10%; text-align: center;"> - </td>
                                                <td>
                                                    <?=
                                                    $form->field($invoice, 'water_unit_from')->dropDownList(ArrayHelper::map(array_reverse(app\models\Energies::getWater($room)), 'water_unit', function ($data) {
                                                                return Yii::$app->formatter->asDate($data['peroid']) . ' [' . $data['water_unit'] . ']';
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
                                    <td style="vertical-align: bottom;"><?= $form->field($invoice, 'water_price')->textInput()->label(false) ?></td>
                                </tr>
                                <?php if(isset($o_invid)){ ?>
                                 <tr>
                                    <td><?= $form->field($invoice, 'additional_1')->textInput(['value'=>'ยอดคงค้าง ['.$o_invid.']'])->label(false) ?></td>
                                    <td><?= $form->field($invoice, 'additional_1_price')->textInput(['value'=>$o_total])->label(false) ?></td>
                                </tr>
                                <?php }else{ ?>
                                <tr>
                                    <td><?= $form->field($invoice, 'additional_1')->textInput(['placeholder' => 'ค่าใช้จ่านอื่น ๆ'])->label(false) ?></td>
                                    <td><?= $form->field($invoice, 'additional_1_price')->textInput()->label(false) ?></td>
                                </tr>
                                <?php } ?>
                                <tr>
                                    <td><?= $form->field($invoice, 'additional_2')->textInput(['placeholder' => 'ค่าใช้จ่านอื่น ๆ'])->label(false) ?></td>
                                    <td><?= $form->field($invoice, 'additional_2_price')->textInput()->label(false) ?></td>
                                </tr>
                                <tr>
                                    <td><?= $form->field($invoice, 'additional_3')->textInput(['placeholder' => 'ค่าใช้จ่านอื่น ๆ'])->label(false) ?></td>
                                    <td><?= $form->field($invoice, 'additional_3_price')->textInput()->label(false) ?></td>
                                </tr>
                                <tr>
                                    <td><?= $form->field($invoice, 'additional_4')->textInput(['placeholder' => 'ค่าใช้จ่านอื่น ๆ'])->label(false) ?></td>
                                    <td><?= $form->field($invoice, 'additional_4_price')->textInput()->label(false) ?></td>
                                </tr>
                                <tr>
                                    <td><?= $form->field($invoice, 'additional_5')->textInput(['placeholder' => 'ค่าใช้จ่านอื่น ๆ'])->label(false) ?></td>
                                    <td><?= $form->field($invoice, 'additional_5_price')->textInput()->label(false) ?></td>
                                </tr>
                                 
                                <tr>
                                    <td style="text-align: center;"><h4>การคืนเงิน</h4></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><?= $form->field($invoice, 'refun_1')->textInput(['value' => 'คืนค่าประกันห้อง', 'readonly' => 'readonly'])->label(false) ?></td>
                                    <td><?= $form->field($invoice, 'refun_1_price')->textInput(['value' => $deposit, 'readonly' => 'readonly'])->label(false) ?></td>
                                </tr>
                                <tr>
                                    <td><?= $form->field($invoice, 'refun_2')->textInput(['placeholder' => 'คืนเงิน'])->label(false) ?></td>
                                    <td><?= $form->field($invoice, 'refun_2_price')->textInput()->label(false) ?></td>
                                </tr>
                                <tr>
                                    <td style="text-align: right; font-size: 16px;"><b>ราคารวม</b></td>
                                    <?php
                                    $total = $invoice->rental + $invoice->deposit;
                                    ?>
                                    <td><?= $form->field($invoice, 'total')->textInput(['value' => $total, 'readonly' => 'readonly'])->label(false) ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="col-lg-6">
                            <?=
                            $form->field($invoice, 'appointment')->widget(Datepicker::className(), [
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
                        <?= $form->field($invoice, 'comment')->textarea(['rows' => 5]) ?>
                        </div>

                        <?= $form->field($invoice, 'status')->hiddenInput(['value' => 'รอการชำระ'])->label(false) ?>

                        <?= $form->field($invoice, 'users_id')->hiddenInput(['value' => Yii::$app->user->identity->id])->label(false) ?>

                            <?= $form->field($invoice, 'invoice_date')->hiddenInput(['value' => $dateCreate])->label(false) ?>

                        <div class="form-group">
<?php // Html::submitButton(' บันทึก', ['class' => 'btn btn-success fa fa-save'])   ?>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>



                <?php // $form->field($model, 'id')->textInput(['maxlength' => true, 'readonly' => 'readonly'])        ?>


<?php //$form->field($model, 'total')->textInput()      ?>



            <?php // ActiveForm::end();   ?>

            </div>
            
        </div>
    </div>
    <div class="col-xs-2 col-sm-2 col-lg-2"></div>
</div>
<div class="form-group">
    <p style="text-align: center;">
<?= Html::submitButton(' บันทึก', ['class' => 'btn btn-success btn-lg fa fa-save']) ?>
    </p>
</div>

<?php ActiveForm::end(); ?>

<?php
            $this->RegisterJs("
    $('document').ready(function(){
    
        WaterCal();
        ElectricCal();
         $('#" . Html::getInputId($invoice, 'rental') . "').change(function(e){ 
            rental = parseInt($('#" . Html::getInputId($invoice, 'rental') . "').val());
           if(isNaN(rental)){
                $('#" .Html::getInputId($invoice, 'rental') . "').val(0); 
            }
           TotalCal();
        });
         $('#" . Html::getInputId($invoice, 'electric_price') . "').change(function(e){ 
            electric_price = parseInt($('#" . Html::getInputId($invoice, 'electric_price') . "').val());
           if(isNaN(electric_price)){
                $('#" .Html::getInputId($invoice, 'electric_price') . "').val(0); 
            }
           TotalCal();
        });
        $('#" . Html::getInputId($invoice, 'water_price') . "').change(function(e){ 
            water_price = parseInt($('#" . Html::getInputId($invoice, 'water_price') . "').val());
           if(isNaN(water_price)){
                $('#" .Html::getInputId($invoice, 'water_price') . "').val(0); 
            }
           TotalCal();
        });
          
        $('#" . Html::getInputId($invoice, 'additional_1_price') . "').change(function(e){ 
           TotalCal();
        });
        $('#" . Html::getInputId($invoice, 'additional_2_price') . "').change(function(e){ 
           TotalCal();
        });
        $('#" . Html::getInputId($invoice, 'additional_3_price') . "').change(function(e){ 
           TotalCal();
        });
        $('#" . Html::getInputId($invoice, 'additional_4_price') . "').change(function(e){ 
           TotalCal();
        });
        $('#" . Html::getInputId($invoice, 'additional_5_price') . "').change(function(e){ 
           TotalCal();
        });
        $('#" . Html::getInputId($invoice, 'refun_1_price') . "').change(function(e){ 
           TotalCal();
        });
        $('#" . Html::getInputId($invoice, 'refun_2_price') . "').change(function(e){ 
           TotalCal();
        });
        
        $('#" . Html::getInputId($invoice, 'water_unit_from') . "').change(function(e){ 
           WaterCal();
        });
        $('#" . Html::getInputId($invoice, 'water_unit_to') . "').change(function(e){ 
           WaterCal();
        });
        $('#" . Html::getInputId($invoice, 'electric_unit_from') . "').change(function(e){ 
           ElectricCal();
        });
        $('#" . Html::getInputId($invoice, 'electric_unit_to') . "').change(function(e){ 
           ElectricCal();
        });
        
        function WaterCal(){
            var unit_from;
            var unit_to;
            var total = 0;
            var price = 0;
            
            unit_from = parseInt($('#" . Html::getInputId($invoice, 'water_unit_from') . "').val());
            unit_to = parseInt($('#" . Html::getInputId($invoice, 'water_unit_to') . "').val());
                
            if(!isNaN(unit_from) && !isNaN(unit_to)){
                total = unit_to - unit_from;
            }
            
            price = total * " . $water . "
            
            $('#" . Html::getInputId($invoice, 'water_unit_total') . "').val(total);
            $('#" . Html::getInputId($invoice, 'water_price') . "').val(price);  
            TotalCal();   
        }
        
        function ElectricCal(){
            var unit_from;
            var unit_to;
            var total = 0;
            var price = 0;
            
            unit_from = parseInt($('#" . Html::getInputId($invoice, 'electric_unit_from') . "').val());
            unit_to = parseInt($('#" . Html::getInputId($invoice, 'electric_unit_to') . "').val());
                
            if(!isNaN(unit_from) && !isNaN(unit_to)){
                total = unit_to - unit_from;
            }
            
            price = total * " . $electric . "
             $('#" . Html::getInputId($invoice, 'electric_unit_total') . "').val(total);
            $('#" . Html::getInputId($invoice, 'electric_price') . "').val(price);  
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
            
            amount = parseInt($('#" . Html::getInputId($invoice, 'total') . "').val());
            room = parseInt($('#" . Html::getInputId($invoice, 'rental') . "').val());
            water_price = parseInt($('#" . Html::getInputId($invoice, 'water_price') . "').val());
            electric_price = parseInt($('#" . Html::getInputId($invoice, 'electric_price') . "').val());
            a1 = parseInt($('#" . Html::getInputId($invoice, 'additional_1_price') . "').val());
            a2 = parseInt($('#" . Html::getInputId($invoice, 'additional_2_price') . "').val());
            a3 = parseInt($('#" . Html::getInputId($invoice, 'additional_3_price') . "').val());
            a4 = parseInt($('#" . Html::getInputId($invoice, 'additional_4_price') . "').val());
            a5 = parseInt($('#" . Html::getInputId($invoice, 'additional_5_price') . "').val());
            refun1 = parseInt($('#" . Html::getInputId($invoice, 'refun_1_price') . "').val());
            refun2 = parseInt($('#" . Html::getInputId($invoice, 'refun_2_price') . "').val());
            
            if(isNaN(room)){
                room = 0;
                $('#" . Html::getInputId($invoice, 'rental') . "').val(room);  
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
            
            if(!isNaN(refun1) && refun1.length != 0){
                total_refun += refun1;
            }
            if(!isNaN(refun2) && refun2.length != 0){
                total_refun += refun2;
            }
            
                       
            total += room;              
            total = total - total_refun;
            $('#" . Html::getInputId($invoice, 'total') . "').val(total);  
        }
        
    });

    ");
            ?>