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
        $table = Content::tableNameUnprefixed();
        $this->isActiveIndex = $table . '_is_active';
        $this->isHiddenIndex = $table . '_is_hidden';
        $this->positionIndex = $table . '_position';
        $this->pathIndex = $table . '_path';
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

        $this->createIndex($this->isActiveIndex, $this->table, 'is_active');
        $this->createIndex($this->isHiddenIndex, $this->table, 'is_hidden');
        $this->createIndex($this->positionIndex, $this->table, 'position');
        $this->createIndex($this->pathIndex, $this->table, 'path');
    }

    public function safeDown()
    {
        $this->dropTable($this->table);
    }
}
