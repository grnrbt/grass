<?php

namespace app\modules\test\models\beds;

use yii\db\ActiveQuery;

class Bed extends \app\models\beds\Bed
{
    public static function tableName()
    {
        return 'test_bed';
    }

    /**
     * @return ActiveQuery
     */
    public function getBlocks()
    {
        return $this
            ->hasMany(BedBlock::class, ['id_bed'=> 'id'])
            ->orderBy('position');
    }

    /**
     * @return ActiveQuery
     */
    public function getEnabledBlocks()
    {
        return $this
            ->getBlocks()
            ->andWhere([BedBlock::tableName().'.is_active' => true]);
    }
}