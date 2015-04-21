<?php

namespace app\modules\Test;

use yii\base\Module;

class Test extends Module
{
    /**
     * @return array
     */
    public static function getAdminLinks()
    {
        return [
            [
                'url' => '/test',
                'title' => 'Тест',
                'items' => [
                    ['url' => '/test/test1', 'title' => 'Тест',],
                ],
            ],
        ];
    }

}