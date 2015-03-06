<?php

namespace app\components;

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

class ActiveRecord extends \yii\db\ActiveRecord
{

    /**
     * function similiar to ActiveRecord::tableName(), but returns not prefixed table name,
     * mostly for index name generation
     * @return string the table name
     */
    public static function tableNameUnprefixed()
    {
        return Inflector::camel2id(StringHelper::basename(get_called_class()), '_');
    }

}