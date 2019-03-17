<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Energies */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin([
    'class' => 'form-control'
]); ?>

<?= $form->field($model, 'rooms_id')->hiddenInput()->label(FALSE) ?>


<?= $form->field($model, 'peroid')->widget(DatePicker::className(),[
    'template' => '{input}{addon}',
    'options' => ['placeholder' => 'รอบวันที่...'],
    'language' => 'th',
        'clientOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd',
            'todayHighlight' => true,
            
        ]
]);?>

<?= $form->field($model, 'water_unit')->textInput(['placeholder' => 'เลขมิเตอร์น้ำปะปา']) ?>

<?= $form->field($model, 'electric_unit')->textInput(['placeholder' => 'เลขมิเตอร์ไฟฟ้า']) ?>



<?= $form->field($model, 'users_id')->hiddenInput()->label(false) ?>

<?= $form->field($model, 'record_date')->hiddenInput()->label(false) ?>

<div class="form-group">
<?= Html::submitButton(' บันทึก', ['class' => 'btn btn-success fa fa-save']) ?>
</div>

<?php ActiveForm::end(); ?>

