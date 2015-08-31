<?php

use app\components\Migration;
use app\models\Config;

class m150304_144746_add_settings extends Migration
{
    private $configTbl;
    private $codeIndex;

    public function init()
    {
        parent::init();
        $this->configTbl = Config::tableName();
        $this->codeIndex = $this->createIndexData($this->configTbl, 'code', true);
    }

    public function getType()
    {
        return self::TYPE_STRUCT;
    }

    public function safeUp()
    {
        $this->db->createCommand("CREATE TYPE config_type AS ENUM('string', 'boolean', 'integer');")->query();

        $this->createTable($this->configTbl, [
            'id' => 'serial primary key',
            'code' => 'varchar(63) not null',
            'type' => 'config_type not null',
            'category' => 'varchar(255) not null',
            'title' => 'varchar(63) not null',
            'description' => 'varchar(255)',
            'value' => 'varchar(255)',
            'ts_updated' => 'timestamp DEFAULT now()',
        ]);

        $this->createIndex(...$this->codeIndex);
    }

    public function safeDown()
    {
        $this->dropIndex(...$this->codeIndex);
        $this->dropTable($this->configTbl);
        $this->db->createCommand('DROP TYPE config_type')->query();
    }
}
