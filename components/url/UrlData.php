<?php

namespace app\components\url;

use yii\base\Object;

class UrlData extends Object
{
    /**
     * @var string
     */
    public $actionId;

    /**
     * @var int
     */
    public $objectId;

    /**
     * @var string|array
     * @see \yii\helpers\BaseUrl::toRoute()
     */
    public $route;

    /**
     * @return string
     */
    public function getActionId()
    {
        return $this->actionId;
    }

    /**
     * @param string $actionId
     * @return UrlData
     */
    public function setActionId($actionId)
    {
        $this->actionId = $actionId;
        return $this;
    }

    /**
     * @return int
     */
    public function getObjectId()
    {
        return $this->objectId;
    }

    /**
     * @param int $objectId
     * @return UrlData
     */
    public function setObjectId($objectId)
    {
        $this->objectId = $objectId;
        return $this;
    }

    /**
     * @return array|string
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @param array|string $route
     * @return UrlData
     */
    public function setRoute($route)
    {
        $this->route = $route;
        return $this;
    }
}