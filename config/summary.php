<?php

\Yii::setAlias('@tests', dirname(__DIR__) . '/tests');

return [
    'basePath' => dirname(__DIR__),
    'sourceLanguage' => 'en-US',
    'modules' => [
        'content' => 'app\modules\content\Content',
    ],
    'components' => [
        'db' => require(__DIR__ . '/db.php'),
        'cache' => 'yii\caching\FileCache',
        'eventManager' => 'app\components\EventManager',
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'app\components\PhpMessageSource',
                ],
            ],
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
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => true,
        ],
    ],
    'params' => require(__DIR__ . '/params.php'),
];