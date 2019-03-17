<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Invoice */
/* @var $form yii\widgets\ActiveForm */


foreach ($dataProvider as $data) {
    $inv_id = $data['id'];
    $leasing_id = $data['leasing_id'];
    $rooms_id = $data['rooms_id'];
    $rental = $data['rental'];
    $deposit = $data['deposit'];
    $electric_unit_from = $data['electric_unit_from'];
    $electric_unit_to = $data['electric_unit_to'];
    $water_unit_from = $data['water_unit_from'];
    $water_unit_to = $data['water_unit_to'];
    $water_price = $data['water_price'];
    $electric_price = $data['electric_price'];
    $a1 = $data['additional_1'];
    $ad1 = $data['additional_1_price'];
    $a2 = $data['additional_2'];
    $ad2 = $data['additional_2_price'];
    $a3 = $data['additional_3'];
    $ad3 = $data['additional_3_price'];
    $a4 = $data['additional_4'];
    $ad4 = $data['additional_4_price'];
    $a5 = $data['additional_5'];
    $ad5 = $data['additional_5_price'];
    $r1 = $data['refun_1'];
    $re1 = $data['refun_1_price'];
    $r2 = $data['refun_2'];
    $re2 = $data['refun_2_price'];
    $total = $data['total'];
    $room = $data['room'];
    $status = $data['status'];
    $cus_name = $data['fullname'];
    $roommate = \app\models\Customers::getFullname($data['roommate_id']);
    $cus_addr = $data['address'];
    $appointment = $data['appointment'];
    $comment = $data['comment'];
    $invoice_date = $data['invoice_date'];
}

$this->title = Yii::$app->name . ' : ใบแจ้งหนี้เลขที่ : ' . $inv_id;

$building = \app\models\Building::getBuilding($rooms_id);
foreach($building as $build){
    $building_name = $build['building_name'];
    $building_addr = $build['building_address'];
}
$company = \app\models\Company::find()->all();
foreach($company as $comp){
    $comp_name = $comp['company_name'];
    $comp_addr = $comp['address'];
}
?>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <!-- Table row -->

                <div class="row">
                    <div class="col-xs-12 table-responsive">
                        <div class="row">

                            <div class="col-lg-6" style="text-align: left;">
                                <h4><?= $building_name ?></h4>
                                <h5><?= $building_addr ?></h5>
                            </div>
                            <div class="col-lg-6" style="text-align: right;">
                                <h4>ใบแจ้งหนี้</h4>
                                <b>เลขที่ : </b><?= $inv_id; ?>
                            </div>


                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <h4>หมายเลขห้อง : <?= $room ?></h4>
                                <b>ผู้เช่า 1 : </b><?= $cus_name ?><br>
                                <b>ผู้เช่า 2 : </b><?= $roommate ?>
                            </div>
                            <div class="col-xs-6" style="text-align: right;">
                                <?php Yii::$app->formatter->timeZone = 'UTC';  ?>
                                <br><b>วันที่ออกบิล : </b><?= Yii::$app->formatter->asDate($invoice_date) ?>
                            <br>
                            <b>กรุณาชำระก่อนวันที่ : </b><?= Yii::$app->formatter->asDate($appointment) ?>
                            </div>
                        </div>
                        <br>
                        <table class="table table-striped">
                            <tr>
                                <th style="width: 70%;">รายการ</th>
                                <th style="width: 30%; text-align: right;">จำนวนเงิน</th>
                            </tr>
                            <tbody>
                                <?php
                                if ($rental != NULL) {
                                    ?>
                                    <tr>
                                        <td>ค่าห้องพัก</td>
                                        <td style="text-align: right;">
                                            <?= Yii::$app->formatter->asDecimal($rental) ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <?php
                                if ($water_price > 0) {
                                    ?>
                                    <tr>
                                        <td>ค่าน้ำ ( <?= $water_unit_from . " - " . $water_unit_to ?>)</td>
                                        <td style="text-align: right;">
                                            <?= Yii::$app->formatter->asDecimal($water_price) ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <?php
                                if ($electric_price > 0) {
                                    ?>
                                    <tr>
                                        <td>ค่าไฟฟ้า ( <?= $electric_unit_from . " - " . $electric_unit_to ?>)</td>
                                        <td style="text-align: right;">
                                            <?= Yii::$app->formatter->asDecimal($electric_price) ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <?php
                                if ($deposit != NULL) {
                                    ?>
                                    <tr>
                                        <td>ค่าประกันห้อง</td>
                                        <td style="text-align: right;">
                                            <?= Yii::$app->formatter->asDecimal($deposit) ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <?php
                                if ($ad1 > 0) {
                                    ?>
                                    <tr>
                                        <td><?= $a1 ?></td>
                                        <td style="text-align: right;">
                                            <?= Yii::$app->formatter->asDecimal($ad1) ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <?php
                                if ($ad2 > 0) {
                                    ?>
                                    <tr>
                                        <td><?= $a2 ?></td>
                                        <td style="text-align: right;">
                                            <?= Yii::$app->formatter->asDecimal($ad2) ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <?php
                                if ($ad3 > 0) {
                                    ?>
                                    <tr>
                                        <td><?= $a3 ?></td>
                                        <td style="text-align: right;">
                                            <?= Yii::$app->formatter->asDecimal($ad3) ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <?php
                                if ($ad4 > 0) {
                                    ?>
                                    <tr>
                                        <td><?= $a4 ?></td>
                                        <td style="text-align: right;">
                                            <?= Yii::$app->formatter->asDecimal($ad4) ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <?php
                                if ($ad5 > 0) {
                                    ?>
                                    <tr>
                                        <td><?= $a5 ?></td>
                                        <td style="text-align: right;">
                                            <?= Yii::$app->formatter->asDecimal($ad5) ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <?php
                                if ($re1 > 0) {
                                    ?>
                                    <tr>
                                        <td><?= $r1 ?></td>
                                        <td style="text-align: right;">
                                            <?= "-" . Yii::$app->formatter->asDecimal($re1) ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <?php
                                if ($re2 > 0) {
                                    ?>
                                    <tr>
                                        <td><?= $r2 ?></td>
                                        <td style="text-align: right;">
                                            <?= "-" . Yii::$app->formatter->asDecimal($re2) ?>
                                        </td>
                                    </tr>
                                <?php } ?>

                                <tr>
                                    <td style="text-align: right; font-size: 20px;"><b>รวม</b></td>
                                    <td style="text-align: right; font-size: 20px;"><b><?= Yii::$app->formatter->asDecimal($total); ?></b></td>
                                </tr>
                                <tr>
                                    <td style="text-align: left;"><b>หมายเหตุ :</b>
                                        <?= $comment ?>
                                    </td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                        <br>
                        <p style="text-align: center;">
                            <?php
                            if ($status === 'รอการชำระ') {
                                echo Html::a(' ยกเลิกใบแจ้งหนี้', ['invoice/delete', 'id' => $inv_id], [
                                    'class' => 'btn btn-danger fa fa-trash',
                                    'data' => [
                                        'confirm' => "คุณต้องการยกเลิก ใบแจ้งหนี้ : ".$inv_id." ใช่หรือไม่ ?",
                                        'method' => 'post',
                                    ]]
                                );
                                ?>
                                &nbsp;
                                <?php
                                echo Html::a(' พิมพ์ใบแจ้งหนี้', ['invoice/print', 'id' => $inv_id], ['target' => '_blank', 'class' => 'btn btn-info fa fa-print']);
                                ?>
                                &nbsp;
                                <?php
                                echo Html::a(' ชำระเงิน', ['receipt/payment', 'id' => $inv_id, 'leasing' => $leasing_id], ['class' => 'btn btn-warning fa fa-money']);
                            }
                            ?>
                        </p>
                    </div>
                    <!-- /.col -->
                </div>


            </div>
        </div>
    </div>
</div>
