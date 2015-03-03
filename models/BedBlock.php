<?php

namespace app\models;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $id_bed
 * @property int $position
 * @property bool $is_enabled
 * @property string $widget_class
 * @property array $params
 */
class BedBlock extends ActiveRecord
{
    public static function tableName()
    {
        return 'bed_block';
    }

    /**
     * @return string
     */
    public function getWidgetClass()
    {
        return $this->widget_class;
    }

    /**
     * @param string $widget_class
     * @return BedBlock
     */
    public function setWidgetClass($widget_class)
    {
        $this->widget_class = $widget_class;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isEnabled()
    {
        return $this->is_enabled;
    }

    /**
     * @param boolean $is_enabled
     * @return BedBlock
     */
    public function setIsEnabled($is_enabled)
    {
        $this->is_enabled = $is_enabled;
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
     * @return BedBlock
     */
    public function setPosition($position)
    {
        $this->position = $position;
        return $this;
    }

    /**
     * @return int
     */
    public function getIdBed()
    {
        return $this->id_bed;
    }

    /**
     * @param int $id_bed
     * @return BedBlock
     */
    public function setIdBed($id_bed)
    {
        $this->id_bed = $id_bed;
        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return BedBlock
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param array $params
     * @return BedBlock
     */
    public function setParams($params)
    {
        $this->params = $params;
        return $this;
    }


}