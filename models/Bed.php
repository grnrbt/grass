<?php

namespace app\models;

use app\components\ActiveRecord;
use yii\db\ActiveQuery;

/**
 * @property int $id
 * @property int $id_proto
 * @property bool $is_default
 * @property BedBlock[] $blocks
 * @property BedBlock[] $enabledBlocks
 */
class Bed extends ActiveRecord
{
    public static function tableName()
    {
        return 'bed';
    }

    /**
     * @return ActiveQuery
     */
    public function getBlocks()
    {
        return $this
            ->hasMany(BedBlock::class, ['id_bed', 'id'])
            ->orderBy('position');
    }

    /**
     * @return ActiveQuery
     */
    public function getEnabledBlocks()
    {
        return $this
            ->getBlocks()
            ->andWhere([BedBlock::tableName() . '.is_enabled' => true]);
    }

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
    public function isIsDefault()
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