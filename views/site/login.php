<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'โปรแกรมบริหารจัดการหอพักรายเดือน';

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];
?>

<div class="login-box" >
    <div class="login-logo">
        <a href="#"><b>โปรแกรมบริหารจัดการหอพักรายเดือน</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">เข้าสู่ระบบ</p>

        <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>

        <?=
                $form
                ->field($model, 'username', $fieldOptions1)
                ->label(false)
                ->textInput(['placeholder' => $model->getAttributeLabel('Username')])
        ?>

        <?=
                $form
                ->field($model, 'password', $fieldOptions2)
                ->label(false)
                ->passwordInput(['placeholder' => $model->getAttributeLabel('Password')])
        ?>

        <div class="row">
            <div class="col-xs-8">
<?= $form->field($model, 'rememberMe')->checkbox(['value' => 0]) ?>
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
        <?= Html::submitButton(' เข้าสู่ระบบ', ['class' => 'btn btn-primary btn-block btn-flat fa', 'name' => 'login-button']) ?>
            </div>
            <!-- /.col -->
        </div>


<?php ActiveForm::end(); ?>
        <p style="text-align: center;">---- OO ----</p>
        <div class="login-logo">
            <a href="#"><b>MGS IT Solution</b></a>
        </div>
        <p class="text-green" style="text-align: center; font-weight: bold;">
            จำหน่าย-ติดตั้ง ระบบ Wifi Hotspot สำหรับหอพัก, โรงแรม, รีสอร์ท
            ระบบกล้องวงจรปิด CCTV, IP Camera, Access Control
            รับเขียนโปรแกรม Website, ร้านค้าออนไลน์ (E-Commerce)
        </p>
        <p style="text-align: center;">
        Tel. 085-0970766 E-Mail : mgsitsolution@gmail.com
        </p>
    </div>
    <!-- /.login-box-body -->
</div><!-- /.login-box -->
