<?php

namespace app\modules\test\models\beds;

class BedBlock extends \app\models\beds\BedBlock
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%test_bed_block}}';
    }
}