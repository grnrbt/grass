<?php

namespace app\models\beds;
use app\components\ActiveRecord;
use app\components\ParamBehavior;

/**
 * @property int $id
 * @property int $id_bed
 * @property int $position
 * @property bool $is_active
 * @property string $source
 * @property array $params
 */
abstract class BedBlock extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => ParamBehavior::className(),
            ]
        ];
    }

    /**
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @param string $source
     * @return BedBlock
     */
    public function setSource($source)
    {
        $this->source = $source;
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
     * @return BedBlock
     */
    public function setIsActive($is_active)
    {
        $this->is_active = $is_active;
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