<?php

namespace app\components;

use yii\console\Exception;

class Migration extends \yii\db\Migration
{
    const TYPE_STRUCT = 'struct';
    const TYPE_BASE = 'base';
    const TYPE_TEST = 'test';

    /**
     * Return type of migration.
     * @return string One of self::TYPE_* constants.
     * @throws Exception
     */
    public function getType()
    {
        throw new Exception('you should define type in getType method');
    }

}