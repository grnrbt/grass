<?php

use app\components\Migration;

class m150824_203504_add_menu_table extends Migration
{
    private $tbl;
    private $positionIndex;
    private $placementIndex;
    private $idMenuIndex;

    public function getType()
    {
        return self::TYPE_STRUCT;
    }

    public function init()
    {
        parent::init();
        $this->tbl = "menu_item"; // TODO: use tableName() method.
        $this->positionIndex = "{$this->tbl}_position";
        $this->placementIndex = "{$this->tbl}_placement";
        $this->idMenuIndex = "{$this->tbl}id_menu";
    }

    public function safeUp()
    {
        $this->createTable($this->tbl, [
            'id' => 'serial primary key',
            'id_menu' => 'integer not null',
            'title' => 'varchar(255)',
            'redirect' => 'varchar(255)',
            'position' => 'smallint not null',
            'placement' => 'smallint not null',
            'params' => 'jsonb NULL',
            'ts_created' => 'timestamp DEFAULT CURRENT_TIMESTAMP',
            'ts_updated' => 'timestamp DEFAULT CURRENT_TIMESTAMP',
        ]);
        $this->createIndex($this->positionIndex, $this->tbl, "position");
        $this->createIndex($this->placementIndex, $this->tbl, "placement");
        $this->createIndex($this->idMenuIndex, $this->tbl, "id_menu");
    }

    public function safeDown()
    {
        $this->dropIndex($this->idMenuIndex, $this->tbl);
        $this->dropIndex($this->positionIndex, $this->tbl);
        $this->dropIndex($this->placementIndex, $this->tbl);
        $this->dropTable($this->tbl);
    }
}
