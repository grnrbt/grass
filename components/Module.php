<?php

namespace app\components;

/**
 * Class Module
 *
 * @package app\components
 */
class Module extends \yii\base\Module
{
    /**
     * @var bool = false Is this module active (it migrates, propagates its block in admin zone etc)
     */
    public $isActive = false;

    /**
     * get links for admin frontend interfaces
     *
     * @return array
     */
    public static function getAdminLinks()
    {

    }
}