<?php

namespace app\models;

use app\components\ActiveRecord;

/**
 * @property string $uri
 * @property int $id_action
 * @property int $id_object
 */
class Route extends ActiveRecord
{
    /**
     * @return int
     */
    public function getIdAction()
    {
        return $this->id_action;
    }

    /**
     * @param int $id_action
     * @return Route
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
     * @return Route
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
     * @return Route
     */
    public function setIdObject($id_object)
    {
        $this->id_object = $id_object;
        return $this;
    }
}