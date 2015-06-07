<?php

namespace app\modules\content;

use app\components\Module;

class Content extends Module
{
    /**
     * @return array
     */
    public static function getAdminLinks()
    {
        return [
            [
                'url' => '/content',
                'title' => 'Страницы',
            ],
        ];
    }
}