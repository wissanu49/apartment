<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $searchModel app\Models\SearchRooms */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::$app->name . ' : ห้องพัก';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
Modal::begin([
    'headerOptions' => ['id' => 'modalHeader'],
    'id' => 'modal',
    'size' => 'modal-lg',
    //keeps from closing modal with esc key or by clicking out of the modal.
    // user must click cancel or X to close
    'clientOptions' => [
        'backdrop' => true, 'keyboard' => true
    ]
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
    <div class=" col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="box">
            <div class="box-header">
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="table-responsive">
                    <?php Pjax::begin(); ?>
<?php // echo $this->render('_search', ['model' => $searchModel]);   ?>

                    <p style="text-align: right;">
                        <?=
                        Html::button(' เพิ่มห้องพัก ', ['value' => Url::to(['rooms/create']),
                            'title' => 'เพิ่มห้องพัก',
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
                            //'building_id',
                            
                            [
                                'attribute' => 'building_id',
                                'format' => 'text',
                                'filter' => Select2::widget([
                                    'model' => $searchModel,
                                    'attribute' => 'building_id',
                                    'data' => ArrayHelper::map(app\models\Building::find()->all(), 'id', 'building_name'),
                                    'theme' => Select2::THEME_BOOTSTRAP,
                                    //'hideSearch' => true,
                                    'options' => [
                                        'placeholder' => 'ค้นหา...',
                                    ],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]),
                                'value' => function($model) {
                                    return $model->building->building_name;
                                }
                            ],
                            [
                                'attribute' => 'name',
                                'format' => 'text',
                                'filter' => Select2::widget([
                                    'model' => $searchModel,
                                    'attribute' => 'name',
                                    'data' => ArrayHelper::map(app\models\rooms::find()->all(), 'name', 'name'),
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
                            //'daily_price',
                            //'monthly_price',
                            /*
                              [
                              'attribute' => 'daily_price',
                              //'filter' => ArrayHelper::map(app\models\Customers::find()->all(), 'id', 'fullname'), //กำหนด filter แบบ dropDownlist จากข้อมูล ใน field แบบ foreignKey
                              'value' => function($model) {
                              return Yii::$app->formatter->asDecimal($model->daily_price);
                              }
                              ],
                             * 
                             */
                            [
                                'attribute' => 'monthly_price',
                                //'filter' => ArrayHelper::map(app\models\Customers::find()->all(), 'id', 'fullname'), //กำหนด filter แบบ dropDownlist จากข้อมูล ใน field แบบ foreignKey
                                'filter' => false,
                                'value' => function($model) {
                                    return Yii::$app->formatter->asDecimal($model->monthly_price);
                                }
                            ],
                            [
                                'attribute' => 'deposit',
                                'filter' => false,
                                //'filter' => ArrayHelper::map(app\models\Customers::find()->all(), 'id', 'fullname'), //กำหนด filter แบบ dropDownlist จากข้อมูล ใน field แบบ foreignKey
                                'value' => function($model) {
                                    return Yii::$app->formatter->asDecimal($model->deposit);
                                }
                            ],
                            //'details:ntext',
                            [
                                'attribute' => 'type',
                                'filter' => Select2::widget([
                                    'model' => $searchModel,
                                    'attribute' => 'type',
                                    'data' => ['ห้องพัดลม' => 'ห้องพัดลม', 'ห้องแอร์' => 'ห้องแอร์'],
                                    'theme' => Select2::THEME_BOOTSTRAP,
                                    //'hideSearch' => true,
                                    'options' => [
                                        'placeholder' => 'ค้นหา...',
                                    ],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]),
                                'value' => function($model) {
                                    return $model->type;
                                }
                            ],
                            [
                                'attribute' => '',
                                'label' => 'หน่วยไฟฟ้า/ปะปา',
                                'format' => 'raw',
                                'value' => function($data) {
                                $str = "<div class=\"btn-group\">
                                            <button type=\"button\" class=\"btn btn-info btn-sm\">จดมิเตอร์.</button>
                                            <button type=\"button\" class=\"btn btn-primary btn-sm dropdown-toggle\" data-toggle=\"dropdown\">
                                              <span class=\"caret\"></span>
                                              <span class=\"sr-only\">Toggle Dropdown</span>
                                            </button>
                                            <ul class=\"dropdown-menu\" role=\"menu\">
                                              <li><button type=\"button\" id=\"showModalButton\" class=\"btn btn-default\" value=\"energies/add?room=$data->id\" title=\"จดมิเตอร์ไฟฟ้า-ปะปา : ".$data['name']."\">จดมิเตอร์ไฟฟ้า-ปะปา</button> 
                                             </li>
                                              <li><li class=\"divider\"></li></li>
                                              <li><button type=\"button\" id=\"showModalButton\" class=\"btn btn-default\" value=\"energies/histories?room=$data->id\" title=\"ดูรายการย้อนหลัง : ".$data['name']."\">ดูรายการย้อนหลัง</button> 
                                              <li><li class=\"divider\"></li></li>
                                              <li><button type=\"button\" id=\"showModalButton\" class=\"btn btn-default\" value=\"energies/bulk?building=$data->building_id\" title=\"จดมิเตอร์แบบหลายห้อง\">จดมิเตอร์แบบหลายห้อง</button> 
                                              </ul>
                                          </div>";
                                    return $str;
                                }
                            ],
                                    /*
                                    [
                                'attribute' => '',
                                'label' => 'หน่วยไฟฟ้า/ปะปา',
                                'format' => 'raw',
                                'value' => function($data) {
                                    return Html::button(' หน่วยไฟฟ้า/ปะปา', ['value' => Url::to(['energies/add', 'room' => $data->id]),
                                                'title' => 'หน่วยไฟฟ้า/ปะปา : ' . $data['name'],
                                                'id' => 'showModalButton',
                                                'class' => 'btn btn-info fa fa-flash',
                                            ]) . " " .
                                            Html::button(' ประวัติ', ['value' => Url::to(['energies/histories', 'room' => $data->id]),
                                                'title' => 'รายการบันทึกทั้งหมด : ' . $data['name'],
                                                'id' => 'showModalButton',
                                                'class' => 'btn btn-warning fa fa-database',
                                    ]);
                                }
                            ],
                                     * 
                                     */
                            [
                                'attribute' => '',
                                'label' => 'ย้ายเข้า/ออก',
                                'format' => 'raw',
                                'value' => function($data) {
                                    $status = \app\models\Leasing::checkRooms($data->id);
                                    if ($status == true) {
                                        return Html::a(' ย้ายเข้า', ['leasing/checkin', 'room' => $data->id], [
                                                    'title' => 'ทำสัญญาเช่า : ' . $data['name'],
                                                    //'id' => 'showModalButton',
                                                    'class' => 'btn btn-success btn-sm fa fa-download',
                                        ]);
                                    } else {

                                        return Html::a(' ย้ายออก', ['leasing/checkout', 'room' => $data->id], [
                                                    'title' => 'ย้ายออก : ' . $data['name'],
                                                    //'id' => 'showModalButton',
                                                    'class' => 'btn btn-danger btn-sm fa fa-upload',
                                        ]);
                                    }
                                }
                            ],
                            [
                                'attribute' => '',
                                'label' => 'ออกใบแจ้งหนี้',
                                'format' => 'raw',
                                'value' => function($data) {
                                    $status = \app\models\Leasing::checkRooms($data->id);
                                    if ($status == false) {
                                        return Html::a(' ออกใบแจ้งหนี้', ['invoice/create', 'room' => $data->id], [
                                                    'title' => 'ออกใบแจ้งหนี้ : ' . $data['name'],
                                                    //'id' => 'showModalButton',
                                                    'class' => 'btn btn-info btn-sm fa fa-money',
                                        ]);
                                    } else {
                                        return "";
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
                                ],
                                'template' => '{update}',
                                'buttons' => [
                                    'update' => function ($url, $model) {
                                        return Html::button('', ['value' => Url::to(['rooms/update', 'id' => $model->id]),
                                                    'title' => 'แก้ไขข้อมูล : ' . $model->name,
                                                    'id' => 'showModalButton',
                                                    'class' => 'btn btn-primary btn-sm fa fa-edit',
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