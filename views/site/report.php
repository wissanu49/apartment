<?php

use yii\helpers\Html;
use app\models\Receipt;
use app\models\Expenses;
use dosamigos\chartjs\ChartJs;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EnergiesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::$app->name.' : สรุปรายรับ-รายจ่าย';
$this->params['breadcrumbs'][] = $this->title;
$i = 0;
foreach ($summary_report as $data) {
    $month[$i] = $data['month'];
    $total[$i] = $data['val'];
    $i++;
}
$j = 0;
foreach ($summary_exp as $exp) {
    $exp_month[$j] = $exp['month'];
    $exp_total[$j] = $exp['val']; //isset($exp['val']) ? 0 : $exp['val'];

    $amount[$j] = $total[$j] - $exp_total[$j];
    $j++;
}
?>
<div class="row">
    <div class="col-md-4 col-sm-4 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-plus"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">รายรับเดือนนี้</span>
                <span class="info-box-number"><?= Yii::$app->formatter->asDecimal(Receipt::ReceiptMonthly()) ?></span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-4 col-sm-4 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-minus"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">รายจ่ายเดือนนี้</span>
                <span class="info-box-number"><?= Yii::$app->formatter->asDecimal(Expenses::ExpensesMonthly()) ?></span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->

    <div class="col-md-4 col-sm-4 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-square"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">ยอดรายรับสุทธิ</span>
                <span class="info-box-number"><?= Yii::$app->formatter->asDecimal(Receipt::ReceiptMonthly() - Expenses::ExpensesMonthly()); ?></span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

        <div class="panel panel-info">
            <div class="panel-heading">
                รายงานรายได้ประจำปี <?= date('Y') + 543; ?>
            </div><!-- /.panel-heading -->
            <div class="panel-body">
                <div class="table-responsive">
                <?=
                ChartJs::widget([
                    'type' => 'bar',
                    'options' => [
                        'height' => 150,
                        'width' => 400
                    ],
                    'data' => [
                        'labels' => $month, //["January", "February", "March", "April", "May", "June", "July"],
                        'datasets' => [
                            [
                                'label' => "รายรับ",
                                'backgroundColor' => "#0FD5ED", //"rgba(179,181,198,0.2)",
                                //'borderColor' => "rgba(179,181,198,1)",
                                'pointBackgroundColor' => "rgba(179,181,198,1)",
                                'pointBorderColor' => "#fff",
                                'pointHoverBackgroundColor' => "#fff",
                                //'pointHoverBorderColor' => "rgba(179,181,198,1)",
                                'data' => $total//[605, 5900, 90, 81, 56, 55, 40]
                            ],
                            [
                                'label' => "รายจ่าย",
                                'backgroundColor' => "#ED270F", //"rgba(255,99,132,0.2)",
                                //'borderColor' => "rgba(255,99,132,1)",
                                'pointBackgroundColor' => "rgba(255,99,132,1)",
                                'pointBorderColor' => "#fff",
                                'pointHoverBackgroundColor' => "#fff",
                                //'pointHoverBorderColor' => "rgba(255,99,132,1)",
                                'data' => $exp_total//[28, 48, 40, 19, 96, 27, 100]
                            ],
                            [
                                'label' => "รายรับสุทธิ",
                                'backgroundColor' => "#1FAC21", //"rgba(255,99,132,0.2)",
                                //'borderColor' => "rgba(255,99,132,1)",
                                'pointBackgroundColor' => "rgba(255,99,132,1)",
                                'pointBorderColor' => "#fff",
                                'pointHoverBackgroundColor' => "#fff",
                                //'pointHoverBorderColor' => "rgba(255,99,132,1)",
                                'data' => $amount//[28, 48, 40, 19, 96, 27, 100]
                            ]
                        ]
                    ]
                ]);
                ?>
                </div>
            </div><!-- /.panel-body -->
        </div><!-- /.panel -->
    </div> 
</div>
