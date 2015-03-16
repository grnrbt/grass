<?php

use app\components\Migration;
use app\models\Config;

class m150304_144746_add_settings extends Migration
{
    public function getType()
    {
        return self::TYPE_STRUCT;
    }

    public function safeUp()
    {
        $this->db->createCommand('CREATE TYPE config_type AS ENUM(\'string\', \'boolean\', \'integer\');')->query();

        $this->createTable(Config::tableName(), [
            'id' => 'serial primary key',
            'code' => 'varchar(63) not null',
            'type' => 'config_type not null',
            'category' => 'varchar(255) not null',
            'title' => 'varchar(63) not null',
            'description' => 'varchar(255)',
            'value' => 'varchar(255)',
            'ts_updated' => 'timestamp DEFAULT CURRENT_TIMESTAMP',
        ]);

        $this->createIndex(Config::tableNameUnprefixed() . '_code', Config::tableName(), 'code');
    }

    public function safeDown()
    {
        $this->dropIndex(Config::tableNameUnprefixed() . '_code', Config::tableName());

        $this->dropTable(Config::tableName());

        $this->db->createCommand('DROP TYPE config_type')->query();
    }
}
