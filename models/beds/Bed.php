<?php

namespace app\models\beds;

use app\components\ActiveRecord;

/**
 * Base class for all beds.
 *
 * @property int $id
 * @property int $id_proto
 * @property bool $is_default
 * @property BedBlock[] $blocks
 */
abstract class Bed extends ActiveRecord
{
    /**
     * @return BedBlockQuery
     */
    abstract public function getBlocks();

    /**
     * @return int
     */
    public function getIdProto()
    {
        return $this->id_proto;
    }

    /**
     * @param int $id_proto
     * @return Bed
     */
    public function setIdProto($id_proto)
    {
        $this->id_proto = $id_proto;
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
     * @return Bed
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isDefault()
    {
        return $this->is_default;
    }

    /**
     * @param boolean $is_default
     * @return Bed
     */
    public function setIsDefault($is_default)
    {
        $this->is_default = $is_default;
        return $this;
    }
}