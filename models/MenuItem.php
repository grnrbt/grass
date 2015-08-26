<?php

namespace app\models;

use app\components\ActiveRecord;

/**
 * Class MenuItem
 *
 * @package app\models
 *
 * @property int $id
 * @property int $id_menu
 * @property string $title
 * @property string $redirect
 * @property int $position
 * @property int $placement
 * @property array $params
 */
class MenuItem extends ActiveRecord
{
    const PLACEMENT_BEFORE = 0;
    const PLACEMENT_AFTER = 1;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getIdMenu()
    {
        return $this->id_menu;
    }

    /**
     * @param int $id_menu
     * @return MenuItem
     */
    public function setIdMenu($id_menu)
    {
        $this->id_menu = $id_menu;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return MenuItem
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getRedirect()
    {
        return $this->redirect;
    }

    /**
     * @param string $redirect
     * @return MenuItem
     */
    public function setRedirect($redirect)
    {
        $this->redirect = $redirect;
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
     * @return MenuItem
     */
    public function setPosition($position)
    {
        $this->position = $position;
        return $this;
    }

    /**
     * @return int
     */
    public function getPlacement()
    {
        return $this->placement;
    }

    /**
     * @param int $placement
     * @return MenuItem
     */
    public function setPlacement($placement)
    {
        if (!in_array($placement, [self::PLACEMENT_AFTER, self::PLACEMENT_BEFORE])) {
            throw new \InvalidArgumentException('$placement argument must be one of self::PLACEMENT_* constants.');
        }

        $this->placement = $placement;
        return $this;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return json_decode($this->params, true);
    }

    /**
     * @param array $params
     * @return MenuItem
     */
    public function setParams($params)
    {
        $this->params = $params;
        return $this;
    }
}