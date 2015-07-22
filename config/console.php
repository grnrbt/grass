<?php

use yii\helpers\ArrayHelper;

$config = ArrayHelper::merge(require(__DIR__ . '/common.php'), [
    'id' => 'grass-console',
    'bootstrap' => ['log', 'init'],
    'controllerNamespace' => 'app\commands',
    'controllerMap' => [
        'migrate' => [
            'class' => \app\commands\MigrateController::class,
        ],
    ],
]);

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = \yii\gii\Module::class;
}

return $config;