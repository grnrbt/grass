<?php

namespace app\modules\content\components;

use app\modules\content\models\Content;
use yii\helpers\Url;

class PageMenu
{
    /**
     * @return array
     */
    public static function generate()
    {
        $result = [];
        $iterator = Content::find()
            ->activeOnly()
            ->visibleOnly()
            ->orderBy(['position' => SORT_ASC]);

        /** @var Content $page */
        foreach ($iterator->each() as $page) {
            $result[] = [
                'url' => Url::toRoute(['/content/page/view','id'=>$page->getId()]),
                'label' => $page->getMenuTitle(),
            ];
        }

        return $result;
    }
}