<?php

namespace app\models;

use app\components\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * Class Config
 *
 * @package app\models
 *
 * @property int $id
 * @property string $category
 * @property string $description
 * @property string $ts_updated
 * @property string $value
 * @property string $code
 * @property string $title
 * @property string $type
 */
class Config extends ActiveRecord
{
    const CACHE_KEY = 'config';

    private static $cache;

    private $types = [
        'string',
        'boolean',
        'integer',
    ];

    /**
     * loads model cache
     */
    public static function loadCache()
    {
        // TODO: hack. We can't run migration until config will load. First migration is faild.
        if (\Yii::$app->getDb()->getSchema()->getTableSchema(static::tableName()) === null) {
            return;
        }

        $cache = \Yii::$app->cache;
        static::$cache = $cache->get(static::CACHE_KEY);

        if (static::$cache === false) {
            $values = Config::find()->asArray()->select(['code', 'value'])->all();
            static::$cache = ArrayHelper::map($values, 'code', 'value');
            $cache->set(static::CACHE_KEY, static::$cache, \Yii::$app->params['configCacheDuration']);
        }
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
        if (isset(static::$cache[$param])) {
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

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => false, // config params are not created in run-time
                'updatedAtAttribute' => 'ts_updated',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        static::loadCache();
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'code', 'category', 'title', 'type',], 'required'],
            ['code', 'unique'],
            ['type', 'in', 'range' => $this->types],
            ['value', 'required', 'when' => function ($model) { return !$model->isNewRecord; }],
            ['value', 'default', 'value' => ''],
            [['code', 'title',], 'string', 'max' => 63],
            [['category', 'description',], 'string', 'max' => 255],
        ];
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
}