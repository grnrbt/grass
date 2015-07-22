<?php

return [
    'config' => [
        'class' => app\modules\config\Config::class,
        'isActive' => true,
    ],
    'test' => [
        'class' => app\modules\test\Test::class,
        'isActive' => true,
    ],
    'content' => [
        'class' => app\modules\content\Content::class,
        'isActive' => true,
    ],
    'user' => [
        'class' => app\modules\user\User::class,
        'isActive' => true,
        'isRegistrationAllowed' => true,
    ],
];