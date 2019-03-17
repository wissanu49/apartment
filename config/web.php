<?php

use \yii\web\Request;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$baseUrl = str_replace('/web', '', (new Request)->getBaseUrl());

$config = [
    'id' => 'apm',
    'timeZone' => 'Asia/Bangkok',
    'basePath' => dirname(__DIR__),
    'name' => 'โปรแกรมบริหารหอพักรายเดือน',
    'bootstrap' => ['log'],
    'defaultRoute' => 'site',
    //'language' => 'th',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'modules' => [
        'gridview' => [
            'class' => '\kartik\grid\Module'
        ],
    ],
    'bootstrap' => [
        'assetsAutoCompress',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'EG-WFTwQTPWxMwgTv82fkDPR1XzqQnuC',
            'baseUrl' => $baseUrl,
        ],
        'meta' => [
            'class' => 'app\components\MetaComponent',
        ],
        
        'assetsAutoCompress' => [
            'class' => '\iisns\assets\AssetsCompressComponent',
            'enabled' => true,
            'jsCompress' => true,
            'cssFileCompile' => true,
            'jsFileCompile' => true,
        ],
        'formatter' => [
            'dateFormat' => 'dd-MM-yyyy',
            //'datetimeFormat' => 'php:d-m-Y H:i:s',
            'decimalSeparator' => '.',
            'thousandSeparator' => ',',
            'currencyCode' => 'THA',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\Users',
            'enableAutoLogin' => false,
            'authTimeout' => 900,
            'enableSession' => true,
            'identityCookie' => ['name' => '_identity-apm', 'httpOnly' => true],
            'loginUrl' => ['login'],
        ],
         'session' => [
            'name' => 'APMSESSION',
             'class' => 'yii\web\Session',
            'timeout' => 900, // 5 minute
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'assetManager' => [
            'bundles' => [
                'dmstr\web\AdminLteAsset' => [
                    'skin' => 'skin-red-light',
                /*
                 * 
                  "skin-blue",
                  "skin-black",
                  "skin-red",
                  "skin-yellow",
                  "skin-purple",
                  "skin-green",
                  "skin-blue-light",
                  "skin-black-light",
                  "skin-red-light",
                  "skin-yellow-light",
                  "skin-purple-light",
                  "skin-green-light"
                 */
                ],
                'yii\web\JqueryAsset' => [
                    'sourcePath' => null,   // do not publish the bundle
                    'js' => [
                        '//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js',
                    ]
                ],
            ],
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'site/index',
                'logout' => 'site/logout',
                'login' => 'site/login',
                'developer' => 'site/developer',
                'customers' => 'customers/index',
                'rooms' => 'rooms/index',
                'building' => 'building/index',
                'leasing' => 'leasing/index',
                'energies' => 'energies/index',
                'invoice' => 'invoice/index',
                'receipt' => 'receipt/index',
                'users' => 'users/index',
                'expenses' => 'expenses/index',
                'company' => 'company/index',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ],
        ],
    ],
    'params' => $params,
];
/*
if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
            // uncomment the following to add your IP if you are not connecting from localhost.
            //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
        //'allowedIPs' => ['127.0.0.1', '::1', '192.168.0.*', '192.168.178.20'],
        'generators' => [//here
            'crud' => [
                'class' => 'yii\gii\generators\crud\Generator',
                'templates' => [
                    'adminlte' => '@vendor/dmstr/yii2-adminlte-asset/gii/templates/crud/simple',
                ]
            ]
        ],
    ];
}
 * 
 */


return $config;
