<?php

namespace app\components;

/**
 * Class Module
 * @package app\components
 *
 * @property boolean $isActive is this module active (it migrates, propagates its block in admin zone etc)
 */
class Module extends \yii\base\Module
{
    public $isActive;
}