<?php

use app\components\Migration;
use \app\models\User;

class m150317_033251_add_users_table extends Migration
{
    private $tableNameUnprefixed;

    private $table;

    public function getType()
    {
        return self::TYPE_STRUCT;
    }

    public function init()
    {
        parent::init();

        $this->tableNameUnprefixed = User::tableNameUnprefixed();
        $this->table = User::tableName();
    }

    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => 'serial primary key',
            'email' => 'varchar(255) NOT NULL',
            'password' => 'varchar(255) NOT NULL',
            'is_active' => 'boolean NOT NULL DEFAULT true',
            'name_first' => 'varchar(255) NULL',
            'name_last' => 'varchar(255) NULL',
            'name_middle' => 'varchar(255) NULL',
            'id_group' => 'smallint  NOT NULL',
            'params' => 'json NULL',
            'auth_key' => 'varchar(255) NULL',
            'reset_key' => 'varchar(255) NULL',
            'ts_created' => 'timestamp DEFAULT CURRENT_TIMESTAMP',
            'ts_updated' => 'timestamp DEFAULT CURRENT_TIMESTAMP',
        ]);

        $this->createIndex($this->tableNameUnprefixed . '_email', $this->table, 'email', true);
        $this->createIndex($this->tableNameUnprefixed . '_auth_key', $this->table, 'auth_key', true);
        $this->createIndex($this->tableNameUnprefixed . '_reset_key', $this->table, 'reset_key', true);
        $this->createIndex($this->tableNameUnprefixed . '_is_active', $this->table, 'is_active');
        $this->createIndex($this->tableNameUnprefixed . '_id_group', $this->table, 'id_group');
    }

    public function safeDown()
    {
        $this->dropIndex($this->tableNameUnprefixed . '_email', $this->table);
        $this->dropIndex($this->tableNameUnprefixed . '_auth_key', $this->table);
        $this->dropIndex($this->tableNameUnprefixed . '_reset_key', $this->table);
        $this->dropIndex($this->tableNameUnprefixed . '_is_active', $this->table);
        $this->dropIndex($this->tableNameUnprefixed . '_id_group', $this->table);

        $this->dropTable($this->table);
    }
}
