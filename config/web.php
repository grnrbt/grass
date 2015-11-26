<?php

use yii\helpers\ArrayHelper;

$config = ArrayHelper::merge(require(__DIR__ . '/common.php'), [
    'id' => 'grass',
    'bootstrap' => ['log', 'init'],
    'components' => [
        'urlManager' => [
            'class' => \app\components\url\UrlManager::class,
            'enablePrettyUrl' => true,
            'enableStrictParsing' => false,
            'showScriptName' => false,
        ],
        'request' => [
            'cookieValidationKey' => 'kNV5z05I6OJ6bE7RwGvXIehylrAhBGJS',
        ],
        'user' => [
            'identityClass' => \app\models\User::class,
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
    $config['modules']['debug'] = \yii\debug\Module::class;

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = \yii\gii\Module::class;
}

return $config;
