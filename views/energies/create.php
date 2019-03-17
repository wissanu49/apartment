<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\Energies */

$this->title = 'Create Energies';
$this->params['breadcrumbs'][] = ['label' => 'Energies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-xs-8">
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
                            </tr>
                        <?php $i++; } ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-4">
        <div class="box">
            <div class="box-header">
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <?php
                $form = ActiveForm::begin([
                            'class' => 'form-control'
                ]);
                ?>

                <?= $form->field($model, 'rooms_id')->hiddenInput()->label(FALSE) ?>


                <?=
                $form->field($model, 'peroid')->widget(DatePicker::className(), [
                    'template' => '{input}{addon}',
                    'options' => ['placeholder' => 'รอบวันที่...'],
                    'language' => 'th',
                    'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                        'todayHighlight' => true,
                    ]
                ]);
                ?>

<?= $form->field($model, 'water_unit')->textInput(['placeholder' => 'เลขมิเตอร์น้ำปะปา']) ?>

                <?= $form->field($model, 'electric_unit')->textInput(['placeholder' => 'เลขมิเตอร์ไฟฟ้า']) ?>



                    <?= $form->field($model, 'users_id')->hiddenInput()->label(false) ?>

<?= $form->field($model, 'record_date')->hiddenInput()->label(false) ?>

                <div class="form-group">
<?= Html::submitButton(' บันทึก', ['class' => 'btn btn-success fa fa-save']) ?>
                </div>

<?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
