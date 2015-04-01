<?php

use app\components\Migration;
use \app\models\User;
use \app\models\Group;

class m150318_165522_add_groups_table extends Migration
{
    private $userTableNameUnprefixed;

    private $userTable;
    private $groupTable;

    public function init()
    {
        parent::init();

        $this->userTableNameUnprefixed = User::tableNameUnprefixed();
        $this->userTable = User::tableName();
        $this->groupTable = Group::tableName();
    }

    public function getType()
    {
        return self::TYPE_STRUCT;
    }

    public function safeUp()
    {
        $this->createTable($this->groupTable, [
                'id' => 'serial primary key',
                'title' => 'varchar(255) NOT NULL',
                'params' => 'jsonb NULL',
                'ts_created' => 'timestamp DEFAULT CURRENT_TIMESTAMP',
                'ts_updated' => 'timestamp DEFAULT CURRENT_TIMESTAMP',
            ]
        );

        $this->addForeignKeyWithAutoNamed($this->userTable, 'id_group', $this->groupTable, 'id', 'cascade', 'cascade');
    }

    public function safeDown()
    {
        $this->dropForeignKey($this->generateFkName($this->userTable, 'id_group', $this->groupTable, 'id'), $this->userTable);

        $this->dropTable($this->groupTable);
    }
}
