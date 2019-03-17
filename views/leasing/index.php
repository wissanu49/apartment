<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\Models\SearchLeasing */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::$app->name . ' : สัญญาเช่า';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
Modal::begin([
    'headerOptions' => ['id' => 'modalHeader'],
    //'id' => 'modal',
    'size' => 'modal-lg',
    'options' => [
        'id' => 'modal',
        'tabindex' => false
    ],
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
                    <?php // echo $this->render('_search', ['model' => $searchModel]);   ?>

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
                                    'data' => ArrayHelper::map(\app\models\Leasing::find()->all(), 'id', 'id'),
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
                            [
                                'attribute' => 'move_in',
                                'format' => 'text',
                                'value' => function($data) {
                                    return Yii::$app->formatter->asDate($data->move_in);
                                },
                                'filter' => DatePicker::widget([
                                    'model' => $searchModel,
                                    'attribute' => 'move_in',
                                    'template' => '{input}{addon}',
                                    'language' => 'th',
                                    'clientOptions' => [
                                        'autoclose' => true,
                                        'format' => 'yyyy-mm-dd'
                                    ]
                                ])
                            ],
                            [
                                'attribute' => 'rooms_id',
                                'format' => 'text',
                                'filter' => Select2::widget([
                                    'model' => $searchModel,
                                    'attribute' => 'rooms_id',
                                    'data' => ArrayHelper::map(\app\models\Rooms::find()->all(), 'id', 'name'),
                                    'theme' => Select2::THEME_BOOTSTRAP,
                                    //'hideSearch' => true,
                                    'options' => [
                                        'placeholder' => 'ค้นหา...',
                                    ],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]),
                                'value' => 'rooms.name',
                            ],
                            /*
                              [
                              'attribute' => 'rooms_id',
                              'label' => 'ห้องพัก',
                              //'format' => 'raw',
                              'value' => 'rooms.name',
                              ],
                             * 
                             */
                            [
                                'attribute' => 'customers_id',
                                'label' => 'ผู้เช่า',
                                'filter' => Select2::widget([
                                    'model' => $searchModel,
                                    'attribute' => 'customers_id',
                                    'data' => ArrayHelper::map(\app\models\Customers::find()->all(), 'id', 'fullname'),
                                    'theme' => Select2::THEME_BOOTSTRAP,
                                    //'hideSearch' => true,
                                    'options' => [
                                        'placeholder' => 'ค้นหา...',
                                    ],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]),
                                'value' => 'customers.fullname',
                            ],
                            //'leasing_date',
                            //'status',
                            //'comment:ntext',
                            [
                                'attribute' => 'status',
                                'label' => 'สถานะ',
                                'format' => 'raw',
                                'filter' => Select2::widget([
                                    'model' => $searchModel,
                                    'attribute' => 'status',
                                    'data' => ['IN' => 'เข้าอยู่', 'OUT' => 'ย้ายออกแล้ว', 'CANCEL' => 'ยกเลิก'],
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
                                    if ($data->status == "IN") {
                                        return Html::button(' เข้าอยู่ ', [
                                                    'value' => NULL,
                                                    //'title' => 'ออกใบแจ้งหนี้ประกันห้อง',
                                                    'class' => 'btn btn-success btn-sm fa fa-lock',
                                                    'disabled' => 'disabled',
                                        ]);
                                    } else if ($data->status == "OUT") {
                                        return Html::button(' ย้ายออกแล้ว ', [
                                                    'value' => NULL,
                                                    //'title' => 'ออกใบแจ้งหนี้ประกันห้อง',
                                                    'class' => 'btn btn-danger btn-sm fa fa-unlock',
                                                    'disabled' => 'disabled',
                                        ]);
                                    } else if ($data->status == "CANCEL") {
                                        return Html::button(' ยกเลิก ', [
                                                    'value' => NULL,
                                                    //'title' => 'ออกใบแจ้งหนี้ประกันห้อง',
                                                    'class' => 'btn btn-warning btn-sm fa fa-unlock',
                                                    'disabled' => 'disabled',
                                        ]);
                                    }
                                }
                            ],
                            [
                                'attribute' => '',
                                'label' => '',
                                'format' => 'raw',
                                'value' => function ($data) {

                                    //$status = \app\models\Invoice::checkInvoice($data->id);
                                    if (($status = \app\models\Invoice::checkInvoice($data->id)) == false && $data->status == 'IN') {
                                        return Html::a('ออกใบแจ้งหนี้ประกันห้อง', ['invoice/deposit', 'leasing' => $data->id], ['class' => 'btn btn-info btn-sm fa fa-edit']);
                                    } else {
                                        return '';
                                    }
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
                                /*
                                  'update' => function ($model, $key, $index) {
                                  return false;
                                  },
                                 * 
                                 */
                                ],
                                'template' => '{update}',
                                'buttons' => [
                                    'update' => function ($url, $data) {
                                        if ($data->status == 'IN') {
                                            return Html::button(' ข้อมูลสัญญา', ['value' => Url::to(['leasing/update', 'id' => $data->id]),
                                                        'title' => 'ข้อมูลสัญญา : '.$data->id,
                                                        'id' => 'showModalButton',
                                                        'class' => 'btn btn-primary btn-sm fa fa-edit'
                                            ]);
                                        } else {
                                            return "";
                                        }
                                    },
                                /*
                                  'checkout' => function ($url, $data) {
                                  if ($data->status == 'IN') {
                                  return Html::button(' ย้ายออก/ยกเลิก', ['value' => Url::to(['leasing/reject', 'id' => $data->id]),
                                  'title' => 'บันทึกย้ายออก',
                                  'id' => 'showModalButton',
                                  'class' => 'btn btn-warning fa fa-o'
                                  ]);
                                  } else {
                                  return Html::button(' ย้ายออก/ยกเลิก', ['value' => Url::to(['leasing/reject', 'id' => $data->id]),
                                  'title' => 'บันทึกย้ายออก',
                                  'id' => 'showModalButton',
                                  'class' => 'btn btn-warning fa fa-o',
                                  'disabled' => 'disabled',
                                  ]);
                                  }
                                  },
                                 */
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