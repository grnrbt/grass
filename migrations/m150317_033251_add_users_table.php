<?php

use app\components\Migration;
use \app\models\User;

class m150317_033251_add_users_table extends Migration
{
    private $userTbl;
    private $emailIndex;
    private $authKeyIndex;
    private $resetKeyIndex;
    private $isActiveIndex;
    private $idGroupIndex;

    public function getType()
    {
        return self::TYPE_STRUCT;
    }

    public function init()
    {
        parent::init();

        $this->userTbl = User::tableName();
        $this->emailIndex = $this->createIndexData($this->userTbl, 'email', true);
        $this->authKeyIndex = $this->createIndexData($this->userTbl, 'auth_key', true);
        $this->resetKeyIndex = $this->createIndexData($this->userTbl, 'reset_key', true);
        $this->isActiveIndex = $this->createIndexData($this->userTbl, 'is_active');
        $this->idGroupIndex = $this->createIndexData($this->userTbl, 'id_group');
    }

    public function safeUp()
    {
        $this->createTable($this->userTbl, [
            'id' => 'serial primary key',
            'email' => 'varchar(255) NOT NULL',
            'password' => 'varchar(255) NOT NULL',
            'is_active' => 'boolean NOT NULL DEFAULT true',
            'name_first' => 'varchar(255) NULL',
            'name_last' => 'varchar(255) NULL',
            'name_middle' => 'varchar(255) NULL',
            'id_group' => 'smallint  NOT NULL',
            'params' => 'jsonb NULL',
            'auth_key' => 'varchar(255) NULL',
            'reset_key' => 'varchar(255) NULL',
            'ts_created' => 'timestamp DEFAULT CURRENT_TIMESTAMP',
            'ts_updated' => 'timestamp DEFAULT CURRENT_TIMESTAMP',
        ]);

        $this->createIndex(...$this->emailIndex);
        $this->createIndex(...$this->authKeyIndex);
        $this->createIndex(...$this->resetKeyIndex);
        $this->createIndex(...$this->isActiveIndex);
        $this->createIndex(...$this->idGroupIndex);
    }

    public function safeDown()
    {
        $this->dropIndex(...$this->emailIndex);
        $this->dropIndex(...$this->authKeyIndex);
        $this->dropIndex(...$this->resetKeyIndex);
        $this->dropIndex(...$this->isActiveIndex);
        $this->dropIndex(...$this->idGroupIndex);

        $this->dropTable($this->userTbl);
    }
}
