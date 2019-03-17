<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchUsers */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::$app->name.' : ผู้ใช้งาน';
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
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header">
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="table-responsive">
                <?php Pjax::begin(); ?>
<?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

                <p style="text-align: right;">
<?= Html::button(' เพิ่มผู้ใช้งาน ', ['value' => Url::to(['users/create']),
                        'title' => 'เพิ่มผู้ใช้งาน',
                        'id' => 'showModalButton',
                        'class' => 'btn btn-success fa fa-plus'
                    ]); ?>
                </p>

                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        //'id',
                        'username',
                        //'password',
                        'fullname',
                        'role',
                        //'status',
                        [
                            'attribute' => '',
                            'format' => 'raw',
                            'value' => function ($data){
                                return Html::button(' เปลี่ยนรหัสผ่าน', ['value' => Url::to(['users/changepwd', 'id' => $data->id]),
                                                'title' => 'เปลี่ยนรหัสผ่าน : ' . $data->fullname,
                                                'id' => 'showModalButton',
                                                'class' => 'btn btn-danger fa fa-gear',
                                    'disabled' => true,
                                    ]);
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
                                    return Html::button('', ['value' => Url::to(['users/update', 'id' => $model->id]),
                                                'title' => 'แก้ไขข้อมูล : ' . $model->fullname,
                                                'id' => 'showModalButton',
                                                'class' => 'btn btn-primary fa fa-edit',
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
