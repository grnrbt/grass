<?php

use app\components\Migration;
use app\models\Param;
use app\models\ParamValue;

class m150313_234943_add_param_catalogue extends Migration
{
    public function getType()
    {
        return self::TYPE_STRUCT;
    }

    public function safeUp()
    {
        $this->db->createCommand('CREATE TYPE param_type AS ENUM(\'string\', \'boolean\', \'integer\', \'decimal\', \'text\', \'select\', \'multiselect\');')->query();

        $this->createTable(Param::tableName(), [
            'id' => 'serial primary key',
            'code' => 'varchar(63) not null',
            'type' => 'param_type not null',
            'is_active' =>  'boolean NOT NULL DEFAULT true',
            'is_global' => 'boolean NOT NULL DEFAULT true',
            'id_module' => 'varchar(63) NULL',
            'value' => 'varchar(255) NOT NULL',
            'source' => 'varchar(255) NOT NULL',
            'title' => 'varchar(63) NOT NULL',
            'description' => 'varchar(255) NULL',
            'position' => 'int DEFAULT 0',
            'ts_created' => 'timestamp DEFAULT CURRENT_TIMESTAMP',
            'ts_updated' => 'timestamp DEFAULT CURRENT_TIMESTAMP',
        ]);

        $this->createIndex(Param::tableNameUnprefixed() . '_code', Param::tableName(), 'code');
        $this->createIndex(Param::tableNameUnprefixed() . '_active', Param::tableName(), 'is_active');

        $this->createTable(ParamValue::tableName(), [
            'id' => 'serial primary key',
            'id_param' => 'integer not null',
            'value' => 'varchar(255) NOT NULL',
            'title' => 'varchar(255) NOT NULL',
            'position' => 'int DEFAULT 0',
        ]);

        $this->createIndex(ParamValue::tableNameUnprefixed() . '_id_param', ParamValue::tableName(), 'id_param');

    }

    public function safeDown()
    {
        $this->dropIndex(Param::tableNameUnprefixed() . '_code', Param::tableName());
        $this->dropIndex(Param::tableNameUnprefixed() . '_active', Param::tableName());

        $this->dropTable(Param::tableName());

        $this->db->createCommand('DROP TYPE param_type')->query();

        $this->dropIndex(ParamValue::tableNameUnprefixed() . '_id_param', ParamValue::tableName());

        $this->dropTable(ParamValue::tableName());
    }
}
