<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use unclead\multipleinput\MultipleInput;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Energies */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'จดเลขมิเตอร์';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <h4 style="color: red;">เพิ่มข้อมูลสูงสุด 10 ห้อง</h4>
                <?php
                $form = ActiveForm::begin([
                            'class' => 'form-control'
                ]);
                ?>
                <?=
                $form->field($model, 'items')->widget(MultipleInput::className(), [
                    'max' => 10,
                    'min' => 1,
                    'columns' => [
                        [
                            'name' => 'rooms_id',
                            'type' => 'dropDownList',
                            'title' => 'ห้องพัก',
                            //'defaultValue' => 1,
                            'items' => ArrayHelper::map(app\models\Rooms::find()->where(['building_id' => $building])->orderBy(['name' => SORT_ASC])->all(), 'id', function($model) {
                                        return $model->name;
                                    }),
                            'enableError' => true,
                            'options' => [
                                'class' => 'new_class',
                                'prompt' => 'ห้องพัก...',
                            ]
                        ],
                        [
                            'name' => 'peroid',
                            'type' => \kartik\date\DatePicker::className(),
                            'title' => 'วันที่จดบันทึก',
                            'value' => function($data) {
                                return date('Y-m-d');
                                $data['peroid'];
                            },
                            'options' => [
                                'pluginOptions' => [
                                    'format' => 'yyyy-mm-dd',
                                    'todayHighlight' => true
                                ]
                            ]
                        ],
                        [
                            'name' => 'water_unit',
                            'title' => 'หน่วยน้ำปะปา',
                            'enableError' => true,
                            'options' => [
                                'class' => 'input-priority'
                            ]
                        ],
                        [
                            'name' => 'electric_unit',
                            'title' => 'หน่วยไฟฟ้า',
                            'enableError' => true,
                            'options' => [
                                'class' => 'input-priority'
                            ]
                        ]
                    ]
                ])->label(false);
                ?>
                <h4 style="color: red;">กรุณาตรวจสอบข้อมูลก่อนการบันทึกทุกครั้ง เพื่อป้องกันการผิดพลาด</h4>
                <div class="form-group">
<?= Html::submitButton(' บันทึก', ['class' => 'btn btn-success fa fa-save']) ?>
                </div>

<?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
