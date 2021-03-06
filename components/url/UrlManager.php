<?php

namespace app\components\url;

use app\components\Module;

class UrlManager extends \yii\web\UrlManager
{
    /** @inheritdoc */
    public function init()
    {
        parent::init();

        foreach (\Yii::$app->getModules() as $id => $module) {
            /** @var Module $class */
            $class = is_array($module) ? $module['class'] : $module::className();
            if (!is_subclass_of($class, Module::class)) {
                continue;
            }

            $rules = $class::getUrlRules();
            foreach ($rules as &$rule) {
                $rule->idModule = $id;
            }
            $this->addRules($rules);
        }
    }
}