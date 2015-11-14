<?php

use app\components\Migration;
use app\models\Route;

class m150919_184935_add_id_module_to_route extends Migration
{
    private $tbl;

    /**
     * @inheritdoc
     */
    public function getType()
    {
        return self::TYPE_STRUCT;
    }

    public function init()
    {
        parent::init();
        $this->tbl = Route::tableName();
    }

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn($this->tbl, 'id_module', 'varchar(100)');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn($this->tbl, 'id_module');
    }
}
