<?php

namespace app\models;

use app\components\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * @property string $uri
 * @property int $route
 * @property int $id_module
 */
class Route extends ActiveRecord
{
    /**
     * get list of all rules for createUrl function
     *
     * @return array|mixed
     * @deprecated
     */
    public static function getRules()
    {
        $rules = \Yii::$app->cache->get('rules');

        if ($rules === false) {
            $rules = ArrayHelper::map(Route::find()->select(['uri', 'id_action'])->asArray()->all(), 'uri', 'id_action');
            \Yii::$app->cache->set('rules', $rules, 60 * 60);
            // todo maybe set dependency on max ts_updated field in DB (need to add that field)
        }

        return $rules;
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
     * @return int
     */
    public function getIdModule()
    {
        return $this->id_module;
    }

    /**
     * @param int $id_module
     * @return $this
     */
    public function setIdModule($id_module)
    {
        $this->id_module = $id_module;
        return $this;
    }

    /** @return int */
    public function getRoute() { return $this->route; }

    /**
     * @param int $route
     * @return Route
     */
    public function setRoute($route)
    {
        $this->route = $route;
        return $this;
    }
}