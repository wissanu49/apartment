<?php

use app\models\Receipt;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EnergiesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'สรุปรายได้แต่ละประเภท';
$this->params['breadcrumbs'][] = $this->title;

$year = date('Y');
$cm = date('m', strtotime('NOW'));
switch ($cm) {
    case '01' :
        $query = 1;
        break;
    case '02' :
        $query = 2;
        break;
    case '03' :
        $query = 3;
        break;
    case '04' :
        $query = 4;
        break;
    case '05' :
        $query = 5;
        break;
    case '06' :
        $query = 6;
        break;
    case '07' :
        $query = 7;
        break;
    case '08' :
        $query = 8;
        break;
    case '09' :
        $query = 9;
        break;
    case '10' :
        $query = 10;
        break;
    case '11' :
        $query = 11;
        break;
    case '12' :
        $query = 12;
        break;
}

$ThaiMonth = ['', 'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];
?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-sm-12">
        <?php
        foreach ($building as $build) {
            //$bid[$b] = $build['id'];
            $j = 1;
            for ($i = 1; $i <= $query; $i++) {
                $sum[$i] = Receipt::find()->
                        select(['SUM(receipt.rental) as rental', 'SUM(receipt.deposit) as deposit', 'SUM(receipt.water_price) as water_price', 'SUM(receipt.electric_price) as electric_price', 'SUM(receipt.additional_1_price) as additional_1_price', 'SUM(receipt.additional_2_price) as additional_2_price', 'SUM(receipt.additional_3_price) as additional_3_price',
                            'SUM(receipt.additional_4_price) as additional_4_price', 'SUM(receipt.additional_5_price) as additional_5_price',])
                        ->leftJoin('invoice', 'invoice.id = receipt.invoice_id')
                        ->leftJoin('rooms', 'rooms.id = invoice.rooms_id')
                        ->leftJoin('building', 'building.id = rooms.building_id')
                        ->where(['month(receipt.receipt_date)' => $i, 'building.id' => $build['id']])
                        ->all();
                $j = $i;
                //'SUM(receipt.refun_1_price) as refun_1_price','SUM(receipt.refun_2_price) as refun_2_price'])
            }
            ?>
            <div class="row">
                <div class="col-xs-12 col-md-12 col-lg-12">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            สรุปรายรับ อาคาร : <?= app\models\Building::getBuildingName($build['id']) ?> ปี <?= date('Y') + 543; ?>
                        </div><!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table table-responsive">
                                <table class="table table-hover table-bordered" style="width: 100%;">

                                    <thead>
                                        <tr>
                                            <th>เดือน</th>
                                            <th>ค่าเช่า</th>
                                            <th>ประกันห้อง</th>
                                            <th>ค่าไฟฟ้า</th>
                                            <th>ค่าน้ำปะปา</th>
                                            <th>อื่น ๆ</th>
                                            <!--<th>คืนเงินประกัน/อื่น ๆ</th>-->
                                            <th>รวม</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $total_price = 0;
                                        for ($k = 1; $k <= $j; $k++) {
                                            foreach ($sum[$k] as $data) {

                                                $add = $data['additional_1_price'] + $data['additional_2_price'] + $data['additional_3_price'] + $data['additional_4_price'] + $data['additional_5_price'];
                                                //$refun = $data['refun_1_price'] + $data['refun_2_price'];
                                                $total = ($add + $data['rental'] + $data['electric_price'] + $data['electric_price'] + $data['deposit']);
                                                $total_price = $total_price + $total;
                                                ?>              
                                                <tr>
                                                    <td><b><?= $ThaiMonth[$k] ?></b></td>
                                                    <td><?= isset($data['rental']) ? Yii::$app->formatter->asDecimal($data['rental']) : "0.00"; ?></td>
                                                    <td><?= isset($data['deposit']) ? Yii::$app->formatter->asDecimal($data['deposit']) : "0.00"; ?></td>
                                                    <td><?= isset($data['electric_price']) ? Yii::$app->formatter->asDecimal($data['electric_price']) : "0.00"; ?></td>
                                                    <td><?= isset($data['electric_price']) ? Yii::$app->formatter->asDecimal($data['water_price']) : "0.00"; ?></td>
                                                    <td><?= isset($add) ? Yii::$app->formatter->asDecimal($add) : "0.00"; ?></td>
                                                    <!--<td><?php // isset($refun) ? Yii::$app->formatter->asDecimal($refun) : "0.00";  ?></td>-->
                                                    <td><b><?= isset($total) ? Yii::$app->formatter->asDecimal($total) : "0.00"; ?></b></td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                    <td><b><?= isset($total_price) ? Yii::$app->formatter->asDecimal($total_price) : "0.00"; ?></b></td>
                                                </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div><!-- /.panel-body -->
                    </div><!-- /.panel -->
                </div> 
            </div>

            <?php
        } // end foreach
        ?>
    </div> 
</div>
