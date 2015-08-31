<?php

use app\components\Migration;
use \app\models\User;
use \app\models\Group;

class m150318_165522_add_groups_table extends Migration
{
    private $userTblNameUnprefixed;

    private $userTbl;
    private $groupTbl;
    private $userIdGroupFk;

    public function init()
    {
        parent::init();

        $this->userTblNameUnprefixed = User::tableNameUnprefixed();
        $this->userTbl = User::tableName();
        $this->groupTbl = Group::tableName();

        $this->userIdGroupFk = $this->generateFkName($this->userTbl, 'id_group', $this->groupTbl, 'id');
    }

    public function getType()
    {
        return self::TYPE_STRUCT;
    }

    public function safeUp()
    {
        $this->createTable($this->groupTbl, [
            'id' => 'serial primary key',
            'title' => 'varchar(255) NOT NULL',
            'params' => 'jsonb NULL',
            'ts_created' => 'timestamp DEFAULT CURRENT_TIMESTAMP',
            'ts_updated' => 'timestamp DEFAULT CURRENT_TIMESTAMP',
        ]);

        $this->addForeignKey($this->userIdGroupFk, $this->userTbl, 'id_group', $this->groupTbl, 'id', 'cascade', 'cascade');
    }

    public function safeDown()
    {
        $this->dropForeignKey($this->userIdGroupFk, $this->userTbl);
        $this->dropTable($this->groupTbl);
    }
}
