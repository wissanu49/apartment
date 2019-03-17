<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\Models\SearchExpenses */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::$app->name.' : รายการค่าใช้จ่าย';
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
                <?php // echo $this->render('_search', ['model' => $searchModel]);   ?>

                <p style="text-align: right;">
                    <?=
                    Html::button(' บันทึกค่าใช้จ่าย ', ['value' => Url::to(['expenses/create']),
                        'title' => 'บันทึกค่าใช้จ่าย',
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
                        //'date_record',
                        [
                            'attribute' => 'date_record',
                            'value' => function($data) {
                                return Yii::$app->formatter->asDate($data['date_record']);
                            }
                        ],
                        //'expenses_1',
                        //'expenses_1_price',
                        //'expenses_2',
                        //'expenses_2_price',
                        //'expenses_3',
                        //'expenses_3_price',
                        //'expenses_4',
                        //'expenses_4_price',
                        //'expenses_5',
                        //'expenses_5_price',
                        //'total',
                        [
                            'attribute' => 'total',
                            'value' => function($data) {
                                return Yii::$app->formatter->asDecimal($data['total']);
                            }
                        ],
                        //'date_record',
                        //'users_id',
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'visibleButtons' => [
                                'view' => function ($model, $key, $index) {
                                    return false;
                                },
                            ],
                            'template' => ' {delete} {update}',
                            'buttons' => [
                                'update' => function ($url, $data) {

                                    return Html::button(' แก้ไข', ['value' => Url::to(['expenses/update', 'id' => $data->id]),
                                                'title' => 'แก้ไขรายการ',
                                                'id' => 'showModalButton',
                                                'class' => 'btn btn-primary fa fa-edit'
                                    ]);
                                },
                                'delete' => function ($url, $data) {

                                    return Html::a(' ยกเลิก',  Url::to(['expenses/delete', 'id' => $data->id]),[
                                                'title' => 'ลบรายการ',
                                                'data' => [
                                                    'confirm' => 'คุณต้องการลบรายการนี้ ใช่ หรือ ไม่?',
                                                    'method' => 'post',
                                                ],
                                                'class' => 'btn btn-danger fa fa-trash'
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
