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

    public function init()
    {
        parent::init();
        $this->bedTbl = Bed::tableName();
        $this->blockTbl = BedBlock::tableName();
        $this->blockIsActiveIndex = $this->blockTbl . '_is_active';
        $this->blockPositionIndex = $this->blockTbl . '_position';
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

        $this->createIndex($this->blockIsActiveIndex, $this->blockTbl, 'is_active');
        $this->createIndex($this->blockPositionIndex, $this->blockTbl, 'position');

        $this->addForeignKeyWithAutoNamed($this->bedTbl, 'id_proto', $this->bedTbl, 'id');
        $this->addForeignKeyWithAutoNamed($this->blockTbl, 'id_bed', $this->bedTbl, 'id', 'cascade', 'cascade');
    }

    public function safeDown()
    {
        $this->dropForeignKey($this->generateFkName($this->bedTbl, 'id_proto', $this->bedTbl, 'id'), $this->bedTbl);
        $this->dropForeignKey($this->generateFkName($this->blockTbl, 'id_bed', $this->bedTbl, 'id'), $this->blockTbl);

        $this->dropIndex($this->blockIsActiveIndex, $this->blockTbl);
        $this->dropIndex($this->blockPositionIndex, $this->blockTbl);

        $this->dropTable($this->blockTbl);
        $this->dropTable($this->bedTbl);
    }
}
