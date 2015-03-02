<?php

namespace app\components;


abstract class Migration extends \yii\db\Migration
{
    const TYPE_STRUCT = 'struct';
    const TYPE_BASE = 'base';
    const TYPE_TEST = 'test';

    /**
     * Return type of migration.
     * @return string One of self::TYPE_* constants.
     */
    public abstract function getType();

}