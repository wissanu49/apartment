<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\Models\SearchCompany */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::$app->name . ' : ข้อมูลบริษัท';
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
                        Html::button(' เพิ่มข้อมูลใหม่ ', ['value' => Url::to(['company/create']),
                            'title' => 'เพิ่มข้อมูลใหม่',
                            'id' => 'showModalButton',
                            'class' => 'btn btn-success fa fa-plus'
                        ]);
                        ?>
                    </p>
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        //'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            //'id',
                            'company_name',
                            'address',
                            'phone',
                            //'logo',
                            //'electric',
                            [
                                'attribute' => 'electric',
                                'value' => function ($data) {
                                    return Yii::$app->formatter->asDecimal($data->electric) . " บาท/หน่วย";
                                }
                            ],
                            [
                                'attribute' => 'water',
                                'value' => function ($data) {
                                    return Yii::$app->formatter->asDecimal($data->water) . " บาท/หน่วย";
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
                                        return Html::button('', ['value' => Url::to(['company/update', 'id' => $model->id]),
                                                    'title' => 'ข้อมูลบริษัท',
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
