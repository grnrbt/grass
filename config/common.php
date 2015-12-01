<?php

\Yii::setAlias('@tests', dirname(__DIR__) . '/tests');

return [
    'basePath' => dirname(__DIR__),
    'sourceLanguage' => 'en-US',
    'modules' => require(__DIR__ . '/modules.php'),
    'components' => [
        'db' => require(__DIR__ . '/db.php'),
        'cache' => \yii\caching\DummyCache::class,
        'eventManager' => \app\components\EventManager::class,
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => \app\components\PhpMessageSource::class,
                ],
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'mailer' => [
            'class' => \yii\swiftmailer\Mailer::class,
            'useFileTransport' => true,
        ],
        'init' => [
            'class' => \app\components\Init::class,
        ],
        'authManager' => [
            'class' => \yii\rbac\PhpManager::class,
            'defaultRoles' => ['admin', 'user'],
        ],
    ],
    'params' => require(__DIR__ . '/params.php'),
];