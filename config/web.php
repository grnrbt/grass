<?php

use yii\helpers\ArrayHelper;

$config = ArrayHelper::merge(require(__DIR__ . '/common.php'), [
    'id' => 'grass',
    'bootstrap' => ['log'],
    'components' => [
        'urlManager' => [
            'class' => 'app\components\UrlManager',
            'enablePrettyUrl' => true,
            'enableStrictParsing' => false,
            'showScriptName' => false,
            'rules' => [],
        ],
        'request' => [
            'cookieValidationKey' => 'kNV5z05I6OJ6bE7RwGvXIehylrAhBGJS',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
]);

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
