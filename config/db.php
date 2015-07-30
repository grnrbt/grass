<?php

return [
    'class' => \yii\db\Connection::class,
    'dsn' => 'pgsql:host=localhost;dbname=grass',
    'username' => 'postgres',
    'password' => 'O9JMVcxUgkiYJFjV33zP',
    'charset' => 'utf8',
    'schemaMap' => [
        'pgsql'=> [
            'class' => \yii\db\pgsql\Schema::class,
            'defaultSchema' => 'public',
        ],
    ],
];
