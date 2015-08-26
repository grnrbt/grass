<?php
/**
 * Application configuration shared by all test types
 */
return [
    'controllerMap' => [
        'fixture' => [
            'class' => 'yii\faker\FixtureController',
            'fixtureDataPath' => '@tests/fixtures',
            'templatePath' => '@tests/templates',
            'namespace' => 'tests\fixtures',
        ],
    ],
    'components' => [
        'urlManager' => [
            'baseUrl' => '',
        ],
        'request' => [
            'class' => \yii\web\Request::class,
            'scriptUrl' => __DIR__ . 'index.php',
        ],
    ],
];
