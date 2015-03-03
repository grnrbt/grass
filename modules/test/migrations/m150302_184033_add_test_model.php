<?php

use app\components\Migration;
use app\modules\test\models\Test;

class m150302_184033_add_test_model extends Migration
{
    public function getType()
    {
        return self::TYPE_STRUCT;
    }

    public function safeUp()
    {
        $this->createTable(Test::tableName(), [
            'id' => 'serial primary key',
            'params' => 'json',
        ]);
    }

    public function safeDown()
    {
        $this->dropTable(Test::tableName());
    }
}
