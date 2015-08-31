<?php

use app\components\Migration;
use app\modules\content\models\beds\Bed;
use app\modules\content\models\beds\BedBlock;

class m150303_074024_added_bed_tables extends Migration
{
    private $bedTbl;
    private $blockTbl;
    private $blockIsActiveIndex;
    private $blockPositionIndex;
    private $bedIdProtoFk;
    private $blockIdBedFk;

    public function init()
    {
        parent::init();
        $this->bedTbl = Bed::tableName();
        $this->blockTbl = BedBlock::tableName();
        $this->blockIsActiveIndex = $this->createIndexData($this->blockTbl, 'is_active');
        $this->blockPositionIndex = $this->createIndexData($this->blockTbl, 'position');
        $this->bedIdProtoFk = $this->createFkData($this->bedTbl, 'id_proto', $this->bedTbl, 'id', 'restrict', 'cascade');
        $this->blockIdBedFk = $this->createFkData($this->blockTbl, 'id_bed', $this->bedTbl, 'id', 'cascade', 'cascade');
    }

    public function getType()
    {
        return self::TYPE_STRUCT;
    }

    public function safeUp()
    {
        $this->createTable($this->bedTbl, [
            'id' => 'serial primary key',
            'id_proto' => 'int',
            'is_default' => 'boolean not null default false',
        ]);

        $this->createTable($this->blockTbl, [
            'id' => 'serial primary key',
            'id_bed' => 'int not null',
            'is_active' => 'boolean not null default true',
            'position' => 'smallint not null',
            'source' => 'varchar(255) not null',
            'params' => 'jsonb',
        ]);

        $this->createIndex(...$this->blockIsActiveIndex);
        $this->createIndex(...$this->blockPositionIndex);

        $this->addForeignKey(...$this->bedIdProtoFk);
        $this->addForeignKey(...$this->blockIdBedFk);
    }

    public function safeDown()
    {
        $this->dropForeignKey(...$this->bedIdProtoFk);
        $this->dropForeignKey(...$this->blockIdBedFk);

        $this->dropIndex(...$this->blockIsActiveIndex);
        $this->dropIndex(...$this->blockPositionIndex);

        $this->dropTable($this->blockTbl);
        $this->dropTable($this->bedTbl);
    }
}
