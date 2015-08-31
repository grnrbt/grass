<?php

use app\components\Migration;
use app\models\MenuItem;

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
        $this->tbl = MenuItem::tableName();
        $this->positionIndex = $this->createIndexData($this->tbl, "position");
        $this->placementIndex = $this->createIndexData($this->tbl, "placement");
        $this->idMenuIndex = $this->createIndexData($this->tbl, "id_menu");
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
        $this->createIndex(...$this->positionIndex);
        $this->createIndex(...$this->placementIndex);
        $this->createIndex(...$this->idMenuIndex);
    }

    public function safeDown()
    {
        $this->dropIndex(...$this->positionIndex);
        $this->dropIndex(...$this->placementIndex);
        $this->dropIndex(...$this->idMenuIndex);
        $this->dropTable($this->tbl);
    }
}
