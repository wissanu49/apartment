<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\Models\SearchReceipt */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::$app->name.' : ใบเสร็จรับเงิน';
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


                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                                'attribute' => 'id',
                                'format' => 'text',
                                'filter' => Select2::widget([
                                    'model' => $searchModel,
                                    'attribute' => 'id',
                                    'data' => ArrayHelper::map(\app\models\Receipt::find()->all(), 'id', 'id'),
                                    'theme' => Select2::THEME_BOOTSTRAP,
                                    //'hideSearch' => true,
                                    'options' => [
                                        'placeholder' => 'ค้นหา...',
                                    ],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]),
                                'value' => 'id',
                            ],
                        //'leasing_id',
                        //'invoice_id',
                        [
                                'attribute' => 'invoice_id',
                                'format' => 'text',
                                'filter' => Select2::widget([
                                    'model' => $searchModel,
                                    'attribute' => 'invoice_id',
                                    'data' => ArrayHelper::map(\app\models\Receipt::find()->all(), 'invoice_id', 'invoice_id'),
                                    'theme' => Select2::THEME_BOOTSTRAP,
                                    //'hideSearch' => true,
                                    'options' => [
                                        'placeholder' => 'ค้นหา...',
                                    ],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]),
                                'value' => 'invoice_id',
                            ],
                        //'rental',
                        //'electric_price',
                        //'water_price',
                        //'additional_1',
                        //'additional_1_price',
                        //'additional_2',
                        //'additional_2_price',
                        //'additional_3',
                        //'additional_3_price',
                        //'additional_4',
                        //'additional_4_price',
                        //'additional_5',
                        //'additional_5_price',
                        //'refun_1',
                        //'refun_1_price',
                        //'refun_2',
                        //'refun_2_price',
                        //'total',
                        [
                            'attribute' => 'rooms_id',
                            'label'=>'ห้องพัก',
                            'filter' => false, 
                            'value' => function ($data) {
                                $room_id = \app\models\Leasing::find()->select('rooms_id')->where(['id' => $data->leasing_id])->one();
                                $room = \app\models\Rooms::find()->select('name')->where(['id' => $room_id->rooms_id])->one();
                                return $room->name;
                                //return $data->rooms->name;
                            }
                        ],
                        [
                            'attribute' => 'total',
                            'filter' => false,
                            'value' => function ($data) {
                                return Yii::$app->formatter->asDecimal($data->total);
                            }
                        ],
                        //'comment',
                        //'users_id',
                        //'receipt_date',
                        [
                            'attribute' => 'receipt_date',
                            'value' => 'receipt_date',
                            'filter' => false,
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'visibleButtons' => [
                                'update' => function ($model, $key, $index) {
                                    return false;
                                },
                                        'delete' => function ($model, $key, $index) {
                                    return false;
                                },
                            ],
                            'template' => '{view} ',
                            'buttons' => [
                                'view' => function ($url, $model) {
                                    return Html::button('', ['value' => Url::to(['receipt/viewreceipt', 'id' => $model->id, 'leasing' => $model->leasing_id]),
                                                'title' => 'ใบเสร็จรับเงิน',
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