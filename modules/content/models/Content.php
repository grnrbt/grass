<?php

namespace app\modules\content\models;


use app\components\ActiveRecord;
use app\components\IObject;
use app\components\ParamBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * Class Content
 * @package app\modules\content\models
 *
 * @property int $id
 * @property string $slug
 * @property boolean $is_active
 * @property boolean $is_hidden
 * @property int $id_parent
 * @property array $ids_bed
 * @property array $path
 * @property string $menu_title
 * @property int $position
 */
class Content extends ActiveRecord Implements IObject
{
    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     * @return $this
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isActive()
    {
        return $this->is_active;
    }

    /**
     * @param boolean $is_active
     * @return $this
     */
    public function setActive($is_active)
    {
        $this->is_active = $is_active;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isHidden()
    {
        return $this->is_hidden;
    }

    /**
     * @param boolean $is_hidden
     * @return $this
     */
    public function setHidden($is_hidden)
    {
        $this->is_hidden = $is_hidden;
        return $this;
    }

    /**
     * @return int
     */
    public function getIdParent()
    {
        return $this->id_parent;
    }

    /**
     * @param int $id_parent
     * @return $this
     */
    public function setIdParent($id_parent)
    {
        $this->id_parent = $id_parent;
        return $this;
    }

    /**
     * @return array
     */
    public function getIdsBed()
    {
        return $this->ids_bed;
    }

    /**
     * @param array $ids_bed
     * @return $this
     */
    public function setIdsBed($ids_bed)
    {
        $this->ids_bed = $ids_bed;
        return $this;
    }

    /**
     * @return array
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param array $path
     * @return $this
     */
    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @return string
     */
    public function getMenuTitle()
    {
        return $this->menu_title;
    }

    /**
     * @param string $menu_title
     * @return $this
     */
    public function setMenuTitle($menu_title)
    {
        $this->menu_title = $menu_title;
        return $this;
    }

    /**
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param int $position
     * @return $this
     */
    public function setPosition($position)
    {
        $this->position = $position;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        ];
    }

    /**
     * @inheritdoc
     */
    public function getBeds()
    {

    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'ts_created',
                'updatedAtAttribute' => 'ts_updated',
            ],
            [
                'class' => ParamBehavior::className(),
            ]
        ];
    }
}