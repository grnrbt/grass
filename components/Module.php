<?php

namespace app\components;

/**
 * Class Module
 *
 * @package app\components
 */
class Module extends \yii\base\Module
{
    use BlockControllerTrait;

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

    /**
     * Get list of menu generators.
     *
     * @return null|array List of generators. Null if there no menus in this module.
     * [
     *  $id => [
     *      'name' => pretty name of generator,
     *      'description' => description of generator logic,
     *      'source' => generator method (callable). Returning value must be comparable with @see \yii\widgets\Menu::items.
     *  ],
     * ]
     */
    public static function getMenus()
    {
        return null;
    }

    /**
     * @param string $id Id of menu
     * @return callable|null Returns menu-generator method.
     */
    public function getMenuSourceById($id)
    {
        $menus = static::getMenus();
        if (!isset($menus[$id])) {
            return null;
        }

        return $menus[$id]['source'];
    }

}