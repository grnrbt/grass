<?php

return [
    'config' => [
        'class' => 'app\modules\config\Config',
        'isActive' => true,
    ],
    'test' => [
        'class' => 'app\modules\test\Test',
        'isActive' => true,
    ],
    'content' => [
        'class' => 'app\modules\content\Content',
        'isActive' => true,
    ],
    'user' => [
        'class' => 'app\modules\user\User',
        'isActive' => true,
        'isRegistrationAllowed' => true,
    ],
];