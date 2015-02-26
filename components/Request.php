<?php

namespace app\components;

/**
 *
 */
class Request extends \yii\web\Request
{
    private $requestedObjectId;

    /**
     * @return mixed
     */
    public function getRequestedObjectId()
    {
        return $this->requestedObjectId;
    }

    /**
     * @param mixed $requestedObjectId
     * @return Request
     */
    public function setRequestedObjectId($requestedObjectId)
    {
        $this->requestedObjectId = $requestedObjectId;
        return $this;
    }
}