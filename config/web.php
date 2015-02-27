<?php

$config = [
    'id' => 'grass',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'sourceLanguage' => 'en-US',
    'modules' => [
        // todo merge it with console config
        'test' => [
            'class' => 'app\modules\test\Test',
        ],
    ],
    'components' => [
        'urlManager' => [
            'class' => 'app\components\UrlManager',
            'enablePrettyUrl' => true,
            'enableStrictParsing' => false,
            'showScriptName' => false,
            'rules' => [],
        ],
        'request' => [
            'class' => 'app\components\Request',
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
        'eventManager' => [
            'class' => 'app\components\EventManager',
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
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'app\components\PhpMessageSource',
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
    ],
    'params' => require(__DIR__ . '/params.php'),
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
