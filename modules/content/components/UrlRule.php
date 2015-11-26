<?php

namespace app\modules\content\components;

use app\modules\content\models\Content;
use yii\web\UrlManager;

class UrlRule extends \app\components\url\UrlRule
{
    /** @inheritdoc */
    protected function generateRouteByPath($path)
    {
        $record = Content::find()
            ->activeOnly()
            ->visibleOnly()
            ->bySlug($path)
            ->one();
        if (!$record) {
            return null;
        }
        return ['/content/page/view', ['id' => $record->getId()]];
    }

    /**
     * Creates a URL according to the given route and parameters.
     *
     * @param UrlManager $manager the URL manager
     * @param string $route the route. It should not have slashes at the beginning or the end.
     * @param array $params the parameters
     * @return string|boolean the created URL, or false if this rule cannot be used for creating this URL.
     */
    public function createUrl($manager, $route, $params)
    {
        // TODO: Implement createUrl() method.
    }
}