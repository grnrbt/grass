<?php

namespace app\modules\test;

use app\modules\test\assets\AdminAsset;
use yii\base\Module;

class Test extends Module
{
    /**
     * @return array
     */
    public static function getAdminLinks()
    {
        $assets = AdminAsset::register(\Yii::$app->view);
        $baseUrl = $assets->baseUrl;

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