<?php

namespace app\modules\user;

use app\components\Module;

class User extends Module
{
    public $isRegistrationAllowed;

    /**
     * @return array
     */
    public static function getAdminLinks()
    {
        return [
            [
                'url' => '/users',
                'title' => 'Пользователи',
            ],
            [
                'url' => '/groups',
                'title' => 'Группы',
            ],
        ];
    }
}