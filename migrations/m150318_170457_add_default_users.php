<?php

use app\components\Migration;
use \app\models\Group;
use \app\models\User;

class m150318_170457_add_default_users extends Migration
{
    private $groupTbl;
    private $userTbl;

    public function init()
    {
        parent::init();
        $this->groupTbl = Group::tableName();
        $this->userTbl = User::tableName();
    }

    public function getType()
    {
        return self::TYPE_BASE;
    }

    public function safeUp()
    {
        $this->batchInsert($this->groupTbl, ['id', 'title'], [
            [1, 'Administrator'],
            [2, 'User']
        ]);

        $sequrity = \Yii::$app->getSecurity();
        $this->batchInsert($this->userTbl, ['id', 'email', 'password', 'id_group'], [
            [1, 'admin@greenrabbit.ru', $sequrity->generatePasswordHash('admin@greenrabbit.ru'), 1],
            [2, 'user@greenrabbit.ru', $sequrity->generatePasswordHash('user@greenrabbit.ru'), 2],
        ]);
    }

    public function safeDown()
    {
        $this->delete($this->userTbl);
        $this->delete($this->groupTbl);
    }
}
