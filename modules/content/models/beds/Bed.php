<?php

namespace app\modules\content\models\beds;
use yii\db\ActiveQuery;

class Bed extends \app\models\beds\Bed
{
    public static function tableName()
    {
        return '{{%content_bed}}';
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
}