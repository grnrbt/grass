<?php

namespace app\modules\content\components\url;

use app\modules\content\models\Content;
use yii\web\Request;
use yii\web\UrlManager;

class UrlRule extends \app\components\url\UrlRule
{
    /**
     * Parses the given request and returns the corresponding route and parameters.
     *
     * @param UrlManager $manager the URL manager
     * @param Request $request the request component
     * @return array|boolean the parsing result. The route and the parameters are returned as an array.
     * If false, it means this rule cannot be used to parse this path info.
     */
    public function parseRequest($manager, $request)
    {
        $path = $request->getPathInfo();
        $record = Content::find()
            ->activeOnly()
            ->visibleOnly()
            ->bySlug($path)
            ->one();

        if (!$record) {
            return false;
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