<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'grass',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'modules' => [
        // todo merge it with console config
        'test' => [
            'class' => 'app\modules\test\Test',
        ],
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => 'kNV5z05I6OJ6bE7RwGvXIehylrAhBGJS',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
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
        'db' => require(__DIR__ . '/db.php'),
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
