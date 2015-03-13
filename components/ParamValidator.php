<?php

namespace app\components;

use yii\helpers\Json;
use yii\validators\Validator;

/**
 * Class ParamValidator
 * @package app\components
 *
 *  param format
 *  [{code: asd, type: string, value: asdf}]
 *  select
 *  [{code: asd, type: fsdg, value: [asdf, sadf]}]
 *  multiselect + dynamic
 *  [{code: asd, type: fsdg, value: [asdf, sadf], source: [class, method]}]
 *  [{code: asd, type: fsdg, value: [asdf, sadf], source: [[class, method], [params,..]]}]
 */
class ParamValidator extends Validator
{
    private $model;
    private $attribute;

    public function types()
    {
        return [
            'string',
            'boolean',
            'integer',
            'decimal',
            'text',
            'select',
            'multiselect',
        ];
    }

    /**
     * @inheritdoc
     */
    public function validateAttribute($model, $attribute)
    {
        // allow null in param
        if(is_null($model->$attribute)){
            return;
        }

        $this->model = $model;
        $this->attribute = $attribute;

        $allPparams = Json::decode($model->$attribute);

        foreach($allPparams as $param){
            if(!in_array($param['type'], $this->types())){
                 $this->addError($model, $attribute, 'Type of param is unknown: ' . $param['type']);
            }
            $validateFunctionName = 'validate' . ucfirst($param['type']);
            $this->$validateFunctionName($param);
        }

        return;
    }

    private function validateString($param)
    {
        if (!is_string($param['value'])) {
            $this->addError($this->model, $this->attribute, 'Value of param '. $param['code'] .' is not valid');

            return;
        }

        $length = mb_strlen($param['value'], \Yii::$app->charset);
        if ($length > 255) {
            $this->addError($this->model, $this->attribute, 'Value of param '. $param['code'] .' is too big');
        }

        return;
    }

    private function validateBoolean($param)
    {
        if(!($param['value'] == 1 || $param['value'] == 0)){
            $this->addError($this->model, $this->attribute, 'Value of param '. $param['code'] .' must be either "1" or "0"');
        }
    }

    private function validateInteger($param)
    {
        if(!$this->checkArray($param)){
            return;
        }
        if (!preg_match('/^\s*[+-]?\d+\s*$/', $param['value'])) {
            $this->addError($this->model, $this->attribute, 'Value of param '. $param['code'] .' must be integer');
        }
    }

    private function validateDecimal($param)
    {
        if(!$this->checkArray($param)){
            return;
        }
        if (!preg_match('/^\s*[-+]?\d+(\.\d{1,2})?\s*$/', $param['value'])) {
            $this->addError($this->model, $this->attribute, 'Value of param '. $param['code'] .' must be decimal');
        }
    }

    private function validateText($param)
    {
        if(!$this->checkArray($param)){
            return;
        }
    }

    private function validateSelect($param)
    {
        if(!$this->checkArray($param)){
            return;
        }

        if(is_array($param['source']) && is_array($param['source'][1])){
            // second place in source is array => this is params for function
            $list = call_user_func_array($param['source'][0], $param['source'][1]);
        } else {
            $list = call_user_func($param['source']);
        }

        if(!in_array($param['value'], $list)){
            $this->addError($this->model, $this->attribute, 'Value of param '. $param['code'] .' not in source list');
        }
    }

    private function validateMultiselect($param)
    {
        if(!$this->checkArray($param, true)){
            return;
        }

        if(is_array($param['source']) && is_array($param['source'][1])){
            // second place in source is array => this is params for function
            $list = call_user_func_array($param['source'][0], $param['source'][1]);
        } else {
            $list = call_user_func($param['source']);
        }

        if (count(array_diff($param['value'], $list))){
            $this->addError($this->model, $this->attribute, 'Some value of param '. $param['code'] .' not in source list');
        }
    }

    private function checkArray($param, $shouldBeArray = false)
    {
        if (!$shouldBeArray && is_array($param['value'])) {
            $this->addError($this->model, $this->attribute, \Yii::t('yii', 'Value of param '. $param['code'] .' must not be array.'));
            return false;
        }

        if ($shouldBeArray && !is_array($param['value'])) {
            $this->addError($this->model, $this->attribute, \Yii::t('yii', 'Value of param '. $param['code'] .' must be array.'));
            return false;
        }

        return true;
    }

}