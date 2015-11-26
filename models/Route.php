<?php

namespace app\models;

use app\components\ActiveRecord;
use app\models\queries\RouteQuery;

/**
 * @property string $uri
 * @property array $route
 * @property string $id_module
 */
class Route extends ActiveRecord
{
    /** @return RouteQuery */
    public static function find()
    {
        return new RouteQuery(static::class);
    }

    /** @inheritdoc */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $route = $this->route;
        if ($route && is_array($route) && count($route) == 2) {
            ksort($route[1]);
        }
        $this->route = json_encode($route);

        return true;
    }

    /** @inheritdoc */
    public function afterFind()
    {
        if ($this->route) {
            $this->route = json_decode($this->route, true);
        }
        parent::afterFind();
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @param string $uri
     * @return $this
     */
    public function setUri($uri)
    {
        $this->uri = $uri;
        return $this;
    }

    /**
     * @return string
     */
    public function getIdModule()
    {
        return $this->id_module;
    }

    /**
     * @param string $id_module
     * @return $this
     */
    public function setIdModule($id_module)
    {
        $this->id_module = $id_module;
        return $this;
    }

    /** @return array */
    public function getRoute() { return $this->route; }

    /**
     * @param array $route
     * @return Route
     */
    public function setRoute($route)
    {
        $this->route = $route;
        return $this;
    }
}