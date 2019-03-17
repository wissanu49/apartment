<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\Models\SearchBuilding */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::$app->name.' : ตึก/อาคาร';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
Modal::begin([
    'headerOptions' => ['id' => 'modalHeader'],
    'id' => 'modal',
    'size' => 'modal-lg',
]);
echo "<div id='modalContent'></div>";
echo "<div id='modalFooter' style=\"text-align:right;\">";
echo Html::button(' Closed ', ['value' => '',
                        'id' => 'close-button',
                        'class' => 'btn btn-danger fa fa-close',
                        'data-dismiss' => 'modal',
    ]);
echo "</div>";
Modal::end();
?>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="box">
            <div class="box-header">
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="table-responsive">
                <?php Pjax::begin(); ?>
                <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

                <p style="text-align: right;">
                    <?=
                    Html::button(' เพิ่มอาคารใหม่ ', ['value' => Url::to(['building/create']),
                        'title' => 'เพิ่มอาคารใหม่',
                        'id' => 'showModalButton',
                        'class' => 'btn btn-success fa fa-plus'
                    ]);
                    ?>
                </p>

                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        //'id',
                        //'building_name',
                        //'company_id',
                        [
                            'attribute' => 'company_id',
                            'format' => 'text',
                            'filter' => Select2::widget([
                                'model' => $searchModel,
                                'attribute' => 'company_id',
                                'data' => ArrayHelper::map(app\models\Company::find()->all(), 'company_name', 'company_name'),
                                'theme' => Select2::THEME_BOOTSTRAP,
                                //'hideSearch' => true,
                                'options' => [
                                    'placeholder' => 'ค้นหา...',
                                ],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]),
                            'value' => function ($data) {
                                 $comp = app\models\Company::find()->select('company_name')->where(['id' => $data->company_id])->one();
                                    return $comp->company_name;
                            }
                        ],
                        [
                            'attribute' => 'building_name',
                            'format' => 'text',
                            'filter' => Select2::widget([
                                'model' => $searchModel,
                                'attribute' => 'building_name',
                                'data' => ArrayHelper::map(app\models\Building::find()->all(), 'building_name', 'building_name'),
                                'theme' => Select2::THEME_BOOTSTRAP,
                                //'hideSearch' => true,
                                'options' => [
                                    'placeholder' => 'ค้นหา...',
                                ],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]),
                        ],
                        'building_address',
                        /*
                        [
                            'attribute' => '',
                            'label' => 'บริหารห้องพัก',
                            'format' => 'raw',
                            'value' => function($data) {
                                return Html::a(' บริหารห้องพัก', ['rooms/building', 'id' => $data['id']], ['title' => 'บริหารห้องพัก : ' . $data['building_name'],
                                            //'id' => 'showModalButton',
                                            'class' => 'btn btn-info fa fa-bed']);
                            }
                        ],
                         * 
                         */
                        [
                            'attribute' => '',
                            'label' => 'จดมิเตอร์ไฟฟ้า/ปะปา',
                            'format' => 'raw',
                            'value' => function($data) {
                                return Html::a(' จดมิเตอร์ไฟฟ้า/ปะปา', ['energies/bulk', 'building' => $data['id']], ['title' => 'บริหารห้องพัก : ' . $data['building_name'],
                                            //'id' => 'showModalButton',
                                            'class' => 'btn btn-primary fa fa-database']);
                            }
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'visibleButtons' => [
                                'view' => function ($model, $key, $index) {
                                    return false;
                                },
                                'delete' => function ($model, $key, $index) {
                                    return false;
                                },
                            ],
                            'template' => '{update}',
                            'buttons' => [
                                'update' => function ($url, $model) {
                                    return Html::button('', ['value' => Url::to(['building/update', 'id' => $model->id]),
                                                'title' => 'แก้ไขข้อมูล : ' . $model->building_name,
                                                'id' => 'showModalButton',
                                                'class' => 'btn btn-primary fa fa-edit'
                                    ]);
                                },
                            ],
                        ],
                    ],
                ]);
                ?>
                <?php Pjax::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
