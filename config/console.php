<?php

use yii\helpers\ArrayHelper;

return ArrayHelper::merge(require(__DIR__ . '/summary.php'), [
    'id' => 'grass-console',
    'bootstrap' => ['log', 'gii'],
    'controllerNamespace' => 'app\commands',
    'modules' => [
        'gii' => 'yii\gii\Module',
    ],
    'controllerMap' => [
        'migrate' => [
            'class' => 'app\commands\MigrateController',
        ],
    ],
]);
