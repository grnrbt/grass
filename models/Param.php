<?php

namespace app\models;

use app\components\ActiveRecord;

/**
 * Class Param
 * @package app\models
 *
 * @property int id
 * @property string code
 * @property string type
 * @property boolean is_active
 * @property boolean is_global this param can be applied only in objects of given module or all objects
 * @property string id_module restrict param only to objects of given module
 * @property string value
 * @property string source source in format [class, method] or [[class, method], [params,..]]
 * @property string title
 * @property string description
 * @property int position
 */
class Param extends ActiveRecord
{
    private $types = [
        'string',
        'boolean',
        'integer',
        'decimal',
        'text',
        'select',
        'multiselect',
    ];

}