<?php

namespace app\modules\content;

use app\components\Module;
use app\modules\content\components\PageMenu;
use app\modules\content\components\url\UrlRule;

class Content extends Module
{
    /** @inheritdoc */
    public static function getUrlRules()
    {
        return [new UrlRule()];
    }

    /** @inheritdoc */
    public static function getAdminLinks()
    {
        return [
            [
                'url' => '/content',
                'title' => 'Страницы',
            ],
        ];
    }

    /** @inheritdoc */
    public static function getMenus()
    {
        return [
            'pages' => [
                'name' => \Yii::t('grass', 'List of pages'),
                'description' => \Yii::t('grass', 'Return list of all pages in module'),
                'source' => [PageMenu::class, 'generate'],
            ],
        ];
    }
}