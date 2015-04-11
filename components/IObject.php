<?php

namespace app\components;
use app\models\beds\Bed;

interface IObject
{
    /**
     * Returns unique id of object.
     * @return  int
     */
    public function getId();

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