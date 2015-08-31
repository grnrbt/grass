<?php

use app\components\Migration;
use app\models\Route;

class m150319_153339_add_auth_pages extends Migration
{
    private $tbl;

    public function init()
    {
        parent::init();
        $this->tbl = Route::tableName();
    }

    public function getType()
    {
        return self::TYPE_BASE;
    }

    public function safeUp()
    {
        $this->batchInsert($this->tbl, ['uri', 'id_action'], [
            ['login', 'site/login'],
            ['logout', 'site/logout'],
        ]);
    }

    public function safeDown()
    {
        $this->delete($this->tbl, ['uri' => ['login', 'logout']]);
    }
}
