<?php

namespace app\components;

use yii\base\ErrorException;

class Migration extends \yii\db\Migration
{
    const TYPE_STRUCT = 'struct';
    const TYPE_BASE = 'base';
    const TYPE_TEST = 'test';

    /**
     * Return type of migration.
     * @return string One of self::TYPE_* constants.
     */
    public function getType()
    {
        return new ErrorException('you should define type in getType method');
    }

}