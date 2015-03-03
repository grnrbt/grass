<?php

namespace app\components;
use app\models\Bed;

/**
 *
 */
interface IObject
{
    /**
     * Return list of beds for this object.
     *
     * @return Bed[]
     * [
     *   <alias> => <bedObject>
     * ]
     */
    public function getBeds();
}