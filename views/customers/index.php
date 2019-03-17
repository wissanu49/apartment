<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\Models\SearchCustomers */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::$app->name.' : ข้อมูลลูกค้า';
$this->params['breadcrumbs'][] = $this->title;


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
                    Html::button(' เพิ่มลูกค้ารายใหม่ ', ['value' => Url::to(['customers/create']),
                        'title' => 'เพิ่มลูกค้ารายใหม่',
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
                        //'fullname',
                        [
                            'attribute' => 'fullname',
                            'format' => 'text',
                            'filter' => Select2::widget([
                                'model' => $searchModel,
                                'attribute' => 'fullname',
                                'data' => ArrayHelper::map(\app\models\Customers::find()->all(), 'fullname', 'fullname'),
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
                        'address:ntext',
                        'work_address:ntext',
                        'phone',
                        //'citizen',
                        //'gender',
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
                                    return Html::button('', ['value' => Url::to(['customers/update', 'id' => $model->id]),
                                                'title' => 'แก้ไขข้อมูลลูกค้า : ' . $model->fullname,
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
