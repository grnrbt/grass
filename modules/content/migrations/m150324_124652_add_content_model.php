<?php

use app\components\Migration;
use app\modules\content\models\Content;

class m150324_124652_add_content_model extends Migration
{
    private $table;
    private $isActiveIndex;
    private $isHiddenIndex;
    private $positionIndex;
    private $pathIndex;

    public function getType()
    {
        return self::TYPE_STRUCT;
    }

    public function init()
    {
        parent::init();
        $this->table = Content::tableName();
        $this->isActiveIndex = $this->createIndexData($this->table, 'is_active');
        $this->isHiddenIndex = $this->createIndexData($this->table, 'is_hidden');
        $this->positionIndex = $this->createIndexData($this->table, 'position');
        $this->pathIndex = $this->createIndexData($this->table, 'path');
    }

    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => 'serial primary key',
            'slug' => 'varchar(255) NOT NULL UNIQUE',
            'is_active' => 'boolean DEFAULT true',
            'is_hidden' => 'boolean DEFAULT false',
            'id_parent' => 'int NULL',
            'ids_bed' => 'jsonb NOT NULL',
            'path' => 'int[]',
            'menu_title' => 'varchar(255) NOT NULL',
            'position' => 'int DEFAULT 0',
            'params' => 'jsonb NULL',
            'ts_created' => 'timestamp DEFAULT CURRENT_TIMESTAMP',
            'ts_updated' => 'timestamp DEFAULT CURRENT_TIMESTAMP',
        ]);

        $this->createIndex(...$this->isActiveIndex);
        $this->createIndex(...$this->isHiddenIndex);
        $this->createIndex(...$this->positionIndex);
        $this->createIndex(...$this->pathIndex);
    }

    public function safeDown()
    {
        $this->dropIndex(...$this->isActiveIndex);
        $this->dropIndex(...$this->isHiddenIndex);
        $this->dropIndex(...$this->positionIndex);
        $this->dropIndex(...$this->pathIndex);
        $this->dropTable($this->table);
    }
}
