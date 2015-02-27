<?php

namespace app\models;

use app\components\ActiveRecord;

/**
 * @property int $id
 * @property string $uri
 * @property int $id_module
 * @property int $id_action
 * @property int $id_object
 */
class Route extends ActiveRecord
{
    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Route
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
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

    /**
     * @return int
     */
    public function getIdModule()
    {
        return $this->id_module;
    }

    /**
     * @param int $id_module
     * @return Route
     */
    public function setIdModule($id_module)
    {
        $this->id_module = $id_module;
        return $this;
    }

}