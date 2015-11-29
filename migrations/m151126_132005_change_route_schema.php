<?php

use app\components\Migration;
use app\models\Route;

class m151126_132005_change_route_schema extends Migration
{
    private $tbl;
    private $idModuleIndex;
    private $routeIndex;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->tbl = Route::tableName();
        $this->idModuleIndex = $this->createIndexData($this->tbl, 'id_module');
        $this->routeIndex = $this->createIndexData($this->tbl, 'route');
    }

    /**
     * @inheritdoc
     */
    public function getType()
    {
        return self::TYPE_STRUCT;
    }

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn($this->tbl, 'route', 'varchar');

        $this->db->createCommand("
            update {$this->tbl}
            set route = concat('[\"', id_action, '\",{}]'),
            id_module= 'core'
        ")->execute();
        $this->db->createCommand("
            alter table {$this->tbl} alter column route set not null
        ")->execute();

        $this->dropColumn($this->tbl, 'id_action');
        $this->dropColumn($this->tbl, 'id_object');
        $this->createIndex(...$this->idModuleIndex);
        $this->createIndex(...$this->routeIndex);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->addColumn($this->tbl, 'id_action', 'varchar(255)');
        $this->addColumn($this->tbl, 'id_object', 'varchar(255)');

        $this->db->createCommand("
            update {$this->tbl}
            set id_action = btrim(route, '[]\"{},')
        ")->execute();
        $this->db->createCommand("
            alter table {$this->tbl} alter id_action set not null
        ")->execute();

        $this->dropIndex(...$this->routeIndex);
        $this->dropIndex(...$this->idModuleIndex);
        $this->dropColumn($this->tbl, 'route');
    }
}
