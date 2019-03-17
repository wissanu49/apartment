<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Leasing */
/* @var $form yii\widgets\ActiveForm */
$dateCreate = date('Y-m-d H:i:s');
?>

<?php $form = ActiveForm::begin(); ?>

<?php // $form->field($model, 'id')->textInput(['maxlength' => true, 'disabled' => true])  ?>
<?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
<div class="row">
    <div class="col-xs-12 col-sm-3 col-md-3">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <?=
                $form->field($model, 'rooms_id')->dropDownList(
                        ArrayHelper::map(app\models\Rooms::find()->all(), 'id', 'name'), ['disabled' => true])
                ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <?= $form->field($model, 'deposit')->textInput(['value' => isset($model->rooms_id) ? $model->rooms->deposit : NULL, 'readonly' => 'readonly']) ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <?= $form->field($model, 'status')->dropDownList(['IN' => 'IN - เข้าพัก', 'CANCEL' => 'CANCEL - ยกเลิกสัญญา']) ?>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <?=
                $form->field($model, 'customers_id')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\models\Customers::find()->orderBy('id DESC')->all(), 'id', 'fullname'),
                    'language' => 'en',
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'options' => ['placeholder' => 'เลือกรายชื่อลูกค้า...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])
                ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <?=
                $form->field($model, 'roommate_id')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\models\Customers::find()->orderBy('id DESC')->all(), 'id', 'fullname'),
                    'language' => 'en',
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'options' => ['placeholder' => 'เลือกรายชื่อลูกค้า...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])
                ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <?=
                $form->field($model, 'move_in')->widget(
                        DatePicker::className(), [
                    // inline too, not bad
                    //'inline' => true, 
                    // modify template for custom rendering
                    //'template' => '<div class="well well-sm" style="background-color: #fff; width:250px">{input}</div>',
                    'template' => '{input}{addon}',
                    'options' => ['placeholder' => 'วันที่ย้ายเข้า'],
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
            <div class="col-xs-12 col-sm-12 col-md-12">
                <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <?= Html::submitButton(' บันทึก', ['class' => 'btn btn-success btn-lg fa fa-save']) ?>
            </div>
        </div>
    </div>
</div>


<?php ActiveForm::end(); ?>
