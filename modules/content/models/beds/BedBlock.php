<?php

namespace app\modules\content\models\beds;

class BedBlock extends \app\models\beds\BedBlock
{
    public static function tableName()
    {
        return '{{%content_bed_block}}';
    }
}