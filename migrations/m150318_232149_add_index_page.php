<?php

use app\components\Migration;
use app\models\Route;

class m150318_232149_add_index_page extends Migration
{
    public function getType()
    {
        return self::TYPE_BASE;
    }

    public function safeUp()
    {
        $this->insert(Route::tableName(), [
            'uri' => '',
            'id_action' => 'site/index',
            'id_object' => '',
        ]);
    }

    public function safeDown()
    {
        $this->delete(Route::tableName(), ['uri' => '']);
    }
}
