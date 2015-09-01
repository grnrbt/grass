<?php

namespace app\models;

use app\components\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * @property string $uri
 * @property int $id_action
 * @property int $id_object
 */
class Route extends ActiveRecord
{
    /**
     * get list of all rules for createUrl function
     * @return array|mixed
     */
    public static function getRules()
    {
        $rules = \Yii::$app->cache->get('rules');

        if(!$rules){
            $rules = ArrayHelper::map(Route::find()->select(['uri', 'id_action'])->asArray()->all(), 'uri', 'id_action');
            \Yii::$app->cache->set('rules', $rules, 60 * 60);
            // todo maybe set dependency on max ts_updated field in DB (need to add that field)
        }

        return $rules;
    }

    /**
     * @return int
     */
    public function getIdAction()
    {
        return $this->id_action;
    }

    /**
     * @param int $id_action
     * @return $this
     */
    public function setIdAction($id_action)
    {
        $this->id_action = $id_action;
        return $this;
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
    public function getIdObject()
    {
        return $this->id_object;
    }

    /**
     * @param int $id_object
     * @return $this
     */
    public function setIdObject($id_object)
    {
        $this->id_object = $id_object;
        return $this;
    }
}