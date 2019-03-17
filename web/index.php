<?php

// comment out the following two lines when deployed to production
//defined('YII_DEBUG') or define('YII_DEBUG', true);
//defined('YII_ENV') or define('YII_ENV', 'dev');

// For Productions
/*
defined('YII_ENV') or define('YII_ENV', 'dev');
  if (@$_GET['debug'] == 1) {
    defined('YII_DEBUG') or define('YII_DEBUG', true);
  } else {
    defined('YII_DEBUG') or define('YII_DEBUG', false);
  }
  */
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application($config))->run();
