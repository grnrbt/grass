<?php

use app\components\Migration;
use \app\models\Group;
use \app\models\User;

class m150318_170457_add_default_users extends Migration
{
    public function getType()
    {
        return self::TYPE_BASE;
    }

    public function safeUp()
    {
        $this->batchInsert(Group::tableName(), ['id', 'title'], [
            [1, 'Administrator'],
            [2, 'User']
        ]);

        $this->batchInsert(User::tableName(), ['id', 'email', 'password', 'id_group'], [
            [1, 'admin@greenrabbit.ru', \Yii::$app->security->generatePasswordHash('admin@greenrabbit.ru'), 1],
            [2, 'user@greenrabbit.ru', \Yii::$app->security->generatePasswordHash('user@greenrabbit.ru'), 2],
        ]);
    }

    public function safeDown()
    {
        $this->delete(User::tableName());
        $this->delete(Group::tableName());
    }
}
