<?php

namespace app\components\url;

use app\components\IObject;

interface IUrlRepository
{
    /**
     * @param IObject $object
     * @param string $scenario = null
     * @return UrlData
     */
    public function getUrlDataByObject(IObject $object, $scenario);
}