<?php

namespace app\components;

use yii\base\Behavior;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\db\Exception;
use yii\validators\Validator;

/**
 * Class ParamBehavior
 * @package app\components
 *
 * @property Model $owner
 */
class ParamBehavior  extends Behavior
{
    private $paramsCache;

    /**
     * @throws Exception
     */
    private function fillCache()
    {
        if(!$this->owner->hasAttribute('param')){
            throw new Exception('Model should have "param" attribute');
        }
        $params = $this->owner->getAttribute('param');
        $this->paramsCache = $params ? json_decode($params) : [];
    }

    /**
     * @param $name
     * @return mixed
     * @throws Exception
     */
    public function getParam($name)
    {
        if(is_null($this->paramsCache)){
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
        if(is_null($this->paramsCache)){
            $this->fillCache();
        }

        $this->paramsCache[$name] = $value;
        $this->owner->setAttribute('param', json_encode($this->paramsCache));

        if($saveObject){
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
        $this->owner->validators[] = Validator::createValidator(ParamValidator::className(), $this->owner, 'param', []);
    }

}