<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = Yii::$app->name.' : MGS IT Solution. E-mail:mgsitsolution@gmail.com';
?>
<?php
foreach ($building as $build) {
    ?>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="box">
                <div class="box-header">
                    <?php
                    $rooms = app\models\Rooms::find()->where(['building_id' => $build->id])->all();
                    $free_fan = 0;
                    $free_air = 0;
                    foreach ($rooms as $rm) {
                         if($rm->status == 'ว่าง' && $rm->type == 'ห้องพัดลม'){
                             $free_fan++;
                         }
                         if($rm->status == 'ว่าง' && $rm->type == 'ห้องแอร์'){
                             $free_air++;
                         }
                        
                    }
                    ?>
                    <h3>อาคาร : <?= $build->building_name ?> </h3>
                    <h4>ห้องพัดลมว่าง <?= $free_fan ?> ห้อง | ห้องแอร์ว่าง <?= $free_air ?> ห้อง</h4>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="table table-responsive">
                        <?php
                        $rooms = app\models\Rooms::find()->where(['building_id' => $build->id])->all();
                        foreach ($rooms as $r) {
                            ?>
                            <div class="col-lg-1 col-sm-2 col-xs-3">
                                <?php if($r->status == 'ว่าง'){ ?>
                                <a href="#" class="btn btn-app" style="background-color: green;"><font style="font-weight: bold; color: #FFFFFF;"><?= $r->name ?><br><?= $r->type ?></font></a>
                                <?php }else{ ?>
                                <a href="#" class="btn btn-app" style="background-color: red;"><font style="font-weight: bold; color: #FFFFFF;"><?= $r->name ?><br><?= $r->type ?></font></a>
                                <?php } ?>
                            </div> 
                        <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php } ?>
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header">
                <h4>ใบแจ้งหนี้รอการชำระ</h4>
            </div>
            <div class="box-body">
                <div class="col-lg-12 col-xs-12">
                    <div class="table table-responsive">
                        <table class="table table-bordered" style="width: 100%;">
                            <tr>
                                <th>เลขที่ใบแจ้งหนี้</th>
                                <th>ห้อง</th>
                                <th>จำนวนเงิน</th>
                                <th>กำหนดชำระ</th>
                                <th></th>
                            </tr>
                            <?php
                            foreach ($invoice as $inv) {
                                //$build_name = app\models\Building::getBuildingName();
                                $room_name = app\models\Rooms::getRoomname($inv->rooms_id);
                                ?>
                                <tr>
                                    <td><?= $inv->id ?></td>
                                    <td><?= $room_name ?></td>
                                    <td><?= Yii::$app->formatter->asDecimal($inv->total) ?></td>
                                    <td><?= Yii::$app->formatter->asDate($inv->appointment) ?></td>
                                    <td><?= Html::a(' ชำระเงิน', ['receipt/payment', 'id' => $inv->id, 'leasing' => $inv->leasing_id], ['class' => 'btn btn-info fa fa-money']) ?></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

