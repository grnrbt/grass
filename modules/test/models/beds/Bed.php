<?php

namespace app\modules\test\models\beds;

use app\models\beds\BedBlockQuery;

class Bed extends \app\models\beds\Bed
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%test_bed}}';
    }

    /**
     * @inheritdoc
     */
    public function getBlocks()
    {
        return $this
            ->hasMany(BedBlock::class, ['id_bed' => 'id'])
            ->orderBy('position');
    }
}