<?php

namespace app\components;

use yii\base\Behavior;
use yii\db\Exception;
use yii\validators\Validator;

/**
 * Class ParamsBehavior
 *
 * @package app\components
 *
 * @property ActiveRecord $owner
 * @method mixed decodeJsonValue(string $value)
 */
class ParamsBehavior extends Behavior
{
    private $paramsCache;

    /**
     * @throws Exception
     */
    private function fillCache()
    {
        if (!$this->owner->hasAttribute('params')) {
            throw new Exception('Model should have "param" attribute');
        }
        $params = $this->owner->getAttribute('params');
        $this->paramsCache = $params ? $this->decodeJsonValue($params) : [];
    }

    /**
     * @param $name
     * @return mixed
     * @throws Exception
     */
    public function getParam($name)
    {
        if (is_null($this->paramsCache)) {
            $this->fillCache();
        }

        return $this->paramsCache[$name];
    }

    /**
     * @param $name
     * @param $value
     * @param bool $saveObject
     * @throws Exception
     */
    public function setParam($name, $value, $saveObject = true)
    {
        if (is_null($this->paramsCache)) {
            $this->fillCache();
        }

        $this->paramsCache[$name] = $value;
        $this->owner->setAttribute('param', json_encode($this->paramsCache));

        if ($saveObject) {
            $this->owner->save();
        }
    }

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeValidate',
        ];
    }

    public function beforeValidate($event)
    {
        $this->owner->validators[] = Validator::createValidator(ParamValidator::class, $this->owner, 'params', []);
    }
}