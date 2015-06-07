<?php

namespace app\modules\config;

use app\components\Module;

class Config extends Module
{
    /**
     * @return array
     */
    public static function getAdminLinks()
    {
        return [
            [
                'url' => '/',
                'title' => 'Общее',
                'items' => [
                    ['url' => 'settings', 'title' => 'Настройки', 'assets' => ['js' => [], 'css' => [], 'html' => []]],
                    ['url' => 'users', 'title' => 'Пользователи',],
                    ['url' => 'groups', 'title' => 'Группы',],
                    ['url' => 'tools', 'title' => 'Инструменты',],
                ],
            ],
        ];
    }

}