<?php

namespace app\components\url;

use app\models\Route;
use yii\base\Object;
use yii\web\UrlRuleInterface;

abstract class UrlRule extends Object implements UrlRuleInterface
{
    /**
     * @var string Unique id of owner-module.
     */
    public $idModule;

    /**
     * Generates and returns route by uri.
     *
     * @param string $uri
     * @return array|null Route for this uri.
     */
    abstract protected function generateRouteByUri($uri);

    /**
     * Generates and returns uri by route and params.
     *
     * @param string $route
     * @param array $params
     * @return string|boolean the created URL, or false if this rule cannot be used for creating this URL.
     */
    abstract protected function generateUriByRoute($route, $params);

    /** @inheritdoc */
    public function parseRequest($manager, $request)
    {
        $uri = $request->getPathInfo();
        $route = $this->findRouteInCache($uri);
        if ($route) {
            return $route;
        }
        $route = $this->generateRouteByUri($uri);

        if ($route) {
            $this->saveRouteToCache($uri, $route);
        }
        return $route ?: false;
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
        // TODO: cache it.
        return $this->generateUriByRoute($route,$params);
    }

    /**
     * Find route in cache by his $uri.
     *
     * @param string $uri
     * @return array|null
     */
    protected function findRouteInCache($uri)
    {
        $key = $this->generateCacheKeyByUri($uri);
        $route = \Yii::$app->getCache()->get($key);
        if ($route) {
            return $route;
        }

        $record = Route::find()
            ->byUri($uri)
            ->one();
        if ($record) {
            $route = $record->getRoute();
            $this->saveRouteToCache($uri, $route, true);
            return $route;
        }

        return null;
    }

    /**
     * Saves route to cache and route table.
     *
     * @param string $uri
     * @param array $route
     * @param bool $toCacheOnly =false Save route into cache only. DO not save it to route table.
     */
    protected function saveRouteToCache($uri, $route, $toCacheOnly = false)
    {
        $key = $this->generateCacheKeyByUri($uri);
        $duration = \Yii::$app->params['routeCacheDuration'];
        \Yii::$app->getCache()->set($key, $route, $duration);

        if (!$toCacheOnly) {
            (new Route())
                ->setUri($uri)
                ->setRoute($route)
                ->setIdModule($this->idModule)
                ->save();
        }
    }

    /**
     * Generates kay for saving route data in cache.
     *
     * @param string $uri
     * @return string
     */
    protected function generateCacheKeyByUri($uri)
    {
        return "route.{$uri}";
    }
}