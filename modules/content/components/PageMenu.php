<?php

namespace app\modules\content\components;

use app\modules\content\components\url\UrlRepository;
use app\modules\content\models\Content;

class PageMenu
{
    /**
     * @return array
     */
    public static function generate()
    {
        $result = [];
        $urlRepository = new UrlRepository();
        $iterator = Content::find()
            ->andWhere(['is_active' => true])
            ->andWhere(['is_hidden' => false])
            ->orderBy(['position' => SORT_ASC]);

        /** @var Content $page */
        foreach ($iterator->each() as $page) {
            $urlData = $urlRepository->getUrlDataByObject($page, UrlRepository::SCENARIO_PAGE_VIEW);
            $result[] = [
                'url' => $urlData->getUrl(),
                'label' => $page->getMenuTitle(),
            ];
        }

        return $result;
    }
}