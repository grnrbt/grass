<?php

namespace app\modules\content\components;

use app\modules\content\models\Content;

class UrlRule extends \app\components\url\UrlRule
{
    private $viewActionId = "/content/page/view";

    /** @inheritdoc */
    protected function generateRouteByPath($path)
    {
        $record = Content::find()
            ->activeOnly()
            ->visibleOnly()
            ->bySlug($path)
            ->one();
        if (!$record) {
            return false;
        }
        return [$this->viewActionId, ['id' => $record->getId()]];
    }

    /** @inheritdoc */
    protected function generatePathByRoute($route, $params)
    {
        if ($route != $this->viewActionId || !isset($params['id'])) {
            return false;
        }

        $record = Content::find()
            ->activeOnly()
            ->visibleOnly()
            ->byId($params['id'])
            ->one();

        if (!$record) {
            return false;
        }
        return $record->slug;
    }
}