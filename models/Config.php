<?php

namespace app\models;

use app\components\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * Class Config
 * @package app\models
 *
 * @property int $id
 * @property string $category
 * @property string $description
 * @property string $ts_updated
 * @property string $value
 * @property string $code
 * @property string $name
 * @property string $type
 */
class Config extends ActiveRecord
{
    private static $cache;

    const CACHE_KEY = 'config';

    private $types = [
        'string',
        'boolean',
        'integer',
    ];

    public function init(){
        static::$cache = \Yii::$app->cache->get(static::CACHE_KEY);
        if(static::$cache === false){
            static::$cache = ArrayHelper::map(Config::find()->asArray()->select(['code', 'value'])->all(), 'code', 'value');
            \Yii::$app->cache->set(static::CACHE_KEY, static::$cache, \Yii::$app->params['configCache']);
        }

        parent::init();
    }

    /**
     * get config parameter
     *
     * @param $param
     * @param bool $default
     * @return bool|static
     */
    public static function get($param, $default = null)
    {
        if(isset(static::$cache[$param])){
            return static::$cache[$param];
        }

        return $default;
    }

    /**
     * set config parameter, no type checking (!)
     *
     * @param $param
     * @param $value
     * @return bool
     */
    public static function set($param, $value)
    {
        if (!array_key_exists($param, static::$cache)) {
            return false;
        }

        static::$cache[$param] = $value;
        $config = Config::findOne(['code' => $param]);
        \Yii::$app->cache->delete(static::CACHE_KEY);
        return $config->setValue($value)->save();
    }

    public function rules()
    {
        return [
            [['id', 'code', 'category', 'name', 'type',], 'required'],
            ['code', 'unique'],
            ['type', 'in', 'range' => $this->types],
            ['value', 'required', 'when' => function ($model) { return !$model->isNewRecord; }],
            ['value', 'default', 'value' => ''],
            [['code', 'name',], 'string', 'max' => 63],
            [['category', 'description',], 'string', 'max' => 255],
        ];
    }



    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    public function getValue()
    {
        return $this->value;
    }
}