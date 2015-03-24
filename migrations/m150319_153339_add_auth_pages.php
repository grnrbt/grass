<?php

use app\components\Migration;
use app\models\Route;

class m150319_153339_add_auth_pages extends Migration
{
    public function getType()
    {
        return self::TYPE_BASE;
    }

    public function safeUp()
    {
        $this->batchInsert(Route::tableName(), ['uri', 'id_action'],
            [
                ['login', 'site/login'],
                ['logout', 'site/logout'],
            ]
        );
    }

    public function safeDown()
    {
        $this->delete(Route::tableName(), ['uri' => ['login', 'logout']]);
    }
}
