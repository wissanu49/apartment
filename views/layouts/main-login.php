<?php
//use backend\assets\AppAsset;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

dmstr\web\AdminLteAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <meta name="description" content="โปรแกรมหอพัก,โปรแกรมบริหารหอพัก,ระบบหอพัก,ระบบอพาร์ทเม้นต์รายเดือน,ระบบ wifi หอพัก,wifi hotspot,wifi หอพัก">
        <meta name="keywords" content="จำหน่ายโปรแกรมหอพัก-พาร์ทเม้นต์ รายวัน/รายเดือน">
    <?php $this->head() ?>
    
</head>
<body class="login-page" ">
<!--
style="background: url(<?php // Yii::getAlias('@web')?>/web/image/main.jpg) no-repeat center center fixed; 
      -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
-->
<?php $this->beginBody() ?>

    <?= $content ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
