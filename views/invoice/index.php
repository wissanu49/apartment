<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\Models\SearchInvoice */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::$app->name . ' : ใบแจ้งหนี้';
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
                                    'data' => ArrayHelper::map(app\models\Invoice::find()->all(), 'id', 'id'),
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
                            //'leasing_id',
                            [
                                'attribute' => 'leasing_id',
                                'format' => 'text',
                                'filter' => Select2::widget([
                                    'model' => $searchModel,
                                    'attribute' => 'leasing_id',
                                    'data' => ArrayHelper::map(app\models\Invoice::find()->all(), 'leasing_id', 'leasing_id'),
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
                            //'room_price',
                            //'electric_unit',
                            //'electric_price',
                            //'water_unit',
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
                            [
                                'attribute' => 'rooms_id',
                                'filter' => false,
                                'value' => function ($data) {
                                    $room = app\models\Rooms::find()->select('name')->where(['id' => $data->rooms_id])->one();
                                    return $room->name;
                                    //return $data->rooms->name;
                                }
                            ],
                            [
                                'attribute' => 'total',
                                //'filter' => true,
                                'value' => function ($data) {
                                    return Yii::$app->formatter->asDecimal($data->total);
                                }
                            ],
                            //'comment',
                            //'status',
                            [
                                'attribute' => 'status',
                                'format' => 'raw',
                                 'filter' => Select2::widget([
                                    'model' => $searchModel,
                                    'attribute' => 'status',
                                    'data' => ['รอการชำระ' => 'รอการชำระ', 'ชำระแล้ว' => 'ชำระแล้ว'],
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
                                    if ($data->status == 'รอการชำระ') {
                                        return Html::button($data->status, [NULL, 'class' => 'btn btn-danger btn-xs', 'disabled'=>true]);
                                    } else {
                                        return Html::button($data->status, [NULL, 'class' => 'btn btn-success btn-xs', 'disabled'=>true]);
                                    }
                                }
                            ],
                            //'appointment',
                            [
                                'attribute' => 'appointment',
                                'format' => 'text',
                                'value' => function($data) {
                                    return Yii::$app->formatter->asDate($data->appointment);
                                },
                                'filter' => DatePicker::widget([
                                    'model' => $searchModel,
                                    'attribute' => 'appointment',
                                    'template' => '{input}{addon}',
                                    'language' => 'th',
                                    'clientOptions' => [
                                        'autoclose' => true,
                                        'format' => 'yyyy-mm-dd'
                                    ]
                                ])
                            ],
                            
                            [
                                'attribute' => '',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    if ($data->status == 'รอการชำระ') {
                                        return Html::a('', ['receipt/payment', 'id' => $data->id, 'leasing' => $data->leasing_id], 
                                                ['class' => 'btn btn-success fa fa-money', 'title'=>'ชำระเงิน']
                                        );
                                    } else {
                                        return "&nbsp;";
                                    }
                                }
                            ],
                                    /*
                                    [
                                'attribute' => '',
                                'label' => 'Actions',
                                'format' => 'raw',
                                'value' => function($data) {
                                $str = "<div class=\"btn-group\">
                                            <button type=\"button\" class=\"btn btn-default\">ทำรายการ.</button>
                                            <button type=\"button\" class=\"btn btn-primary dropdown-toggle\" data-toggle=\"dropdown\">
                                              <span class=\"caret\"></span>
                                              <span class=\"sr-only\">Toggle Dropdown</span>
                                            </button>
                                            <ul class=\"dropdown-menu\" role=\"menu\">
                                            
                                              <li><button type=\"button\" id=\"showModalButton\" class=\"btn btn-info fa fa-file\" value=\"/apartment/invoice/view?id=$data->id\" title=\"ข้อมูลใบแจ้งหนี้ : $data->id\"> ข้อมูลใบแจ้งหนี้</button> 
                                        </li>
                                        <li><li class=\"divider\"></li></li>
                                              <li><a href=\"/apartment/invoice/update?id=$data->id\"> แก้ไขข้อมูลใบแจ้งหนี้</a> 
                                              </ul>
                                          </div>";
                                    return $str;
                                }
                            ],
                                   */
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'visibleButtons' => [
                                    //'update' => function ($model, $key, $index) {
                                    //    return false;
                                    //},
                                    'delete' => function ($model, $key, $index) {
                                        return false;
                                    },
                                ],
                                'template' => '{view} {update}',
                                'buttons' => [
                                    'view' => function ($url, $model) {
                                        return Html::button(' ใบแจ้งหนี้', ['value' => Url::to(['invoice/view', 'id' => $model->id]),
                                                    'title' => 'ข้อมูลใบแจ้งหนี้',
                                                    'id' => 'showModalButton',
                                                    'class' => 'btn btn-info fa fa-file'
                                        ]);
                                    },
                                    'update' => function ($url, $model) {
                                        if ($model->status == 'รอการชำระ') {
                                            return Html::a(' แก้ไข', Url::to(['invoice/update', 'id' => $model->id]), [
                                                        'title' => 'แก้ไขข้อมูลใบแจ้งหนี้',
                                                        //'id' => 'showModalButton',
                                                        'class' => 'btn btn-primary fa fa-edit'
                                            ]);
                                        }
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
