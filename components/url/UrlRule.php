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
     * Generates and returns route by path.
     *
     * @param string $path
     * @return array|null Route for this path.
     */
    abstract protected function generateRouteByPath($path);

    /** @inheritdoc */
    public function parseRequest($manager, $request)
    {
        $path = $request->getPathInfo();
        $route = $this->findRouteInCache($path);
        if ($route) {
            return $route;
        }
        $route = $this->generateRouteByPath($path);

        if ($route) {
            $this->saveRouteToCache($path, $route);
        }
        return $route;
    }

    /**
     * Find route in cache by his path.
     *
     * @param string $path
     * @return array|null
     */
    protected function findRouteInCache($path)
    {
        $key = $this->generateCacheKeyByPath($path);
        $route = \Yii::$app->getCache()->get($key);
        if ($route) {
            return $route;
        }

        $record = Route::find()
            ->byUri($path)
            ->one();
        if ($record) {
            $route = $record->getRoute();
            $this->saveRouteToCache($path, $route, true);
            return $route;
        }

        return null;
    }

    /**
     * Saves route to cache and route table.
     *
     * @param string $path
     * @param array $route
     * @param bool $toCacheOnly =false Save route into cache only. DO not save it to route table.
     */
    protected function saveRouteToCache($path, $route, $toCacheOnly = false)
    {
        $key = $this->generateCacheKeyByPath($path);
        $duration = \Yii::$app->params['routeCacheDuration'];
        \Yii::$app->getCache()->set($key, $route, $duration);

        if (!$toCacheOnly) {
            (new Route())
                ->setUri($path)
                ->setRoute($route)
                ->setIdModule($this->idModule)
                ->save();
        }
    }

    /**
     * Generates kay for saving route data in cache.
     *
     * @param string $path
     * @return string
     */
    protected function generateCacheKeyByPath($path)
    {
        return "route.{$path}";
    }
}