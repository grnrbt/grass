<?php

use app\components\Migration;
use app\models\Route;

class m150228_122534_add_route_table extends Migration
{
    public function getType()
    {
        return self::TYPE_STRUCT;
    }

    public function safeUp()
    {
        $this->createTable(Route::tableName(), [
            'uri' => 'varchar(255) not null primary key',
            'id_action' => 'varchar(255) not null',
            'id_object' => 'varchar(255)',
        ]);
    }

    public function safeDown()
    {
        $this->dropTable(Route::tableName());
    }
}
