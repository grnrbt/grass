<?php

use app\components\Migration;
use app\models\Param;
use app\models\ParamValue;

class m150313_234943_add_param_catalogue extends Migration
{
    private $paramTbl;
    private $valueTbl;
    private $paramCodeIndex;
    private $paramIsActiveIndex;
    private $valueIdParamIndex;

    public function init()
    {
        parent::init();
        $this->paramTbl = Param::tableName();
        $this->valueTbl = ParamValue::tableName();
        $this->paramCodeIndex = $this->createIndexData($this->paramTbl, 'code', true);
        $this->paramIsActiveIndex = $this->createIndexData($this->paramTbl, 'is_active');
        $this->valueIdParamIndex = $this->createIndexData($this->valueTbl, 'id_param');
    }

    public function getType()
    {
        return self::TYPE_STRUCT;
    }

    public function safeUp()
    {
        $this->db->createCommand(
            "CREATE TYPE param_type AS ENUM('string', 'boolean', 'integer', 'decimal', 'text', 'select', 'multiselect');"
        )->query();

        $this->createTable($this->paramTbl, [
            'id' => 'serial primary key',
            'code' => 'varchar(63) not null',
            'type' => 'param_type not null',
            'is_active' => 'boolean NOT NULL DEFAULT true',
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

        $this->createIndex(...$this->paramCodeIndex);
        $this->createIndex(...$this->paramIsActiveIndex);

        $this->createTable($this->valueTbl, [
            'id' => 'serial primary key',
            'id_param' => 'integer not null',
            'value' => 'varchar(255) NOT NULL',
            'title' => 'varchar(255) NOT NULL',
            'position' => 'int DEFAULT 0',
        ]);

        $this->createIndex(...$this->valueIdParamIndex);

    }

    public function safeDown()
    {
        $this->dropIndex(...$this->paramCodeIndex);
        $this->dropIndex(...$this->paramIsActiveIndex);
        $this->dropTable($this->paramTbl);
        $this->db->createCommand('DROP TYPE param_type')->query();
        $this->dropIndex(...$this->valueIdParamIndex);
        $this->dropTable($this->valueTbl);
    }
}
