<?php

namespace app\tests\unit\fixtures\blocks\menu;

use app\models\MenuItem;
use yii\test\Fixture;

class MenuBlockFixture extends Fixture
{
    public function load()
    {
        $db = \Yii::$app->getDb();

        MenuItem::deleteAll();
        $db->createCommand()->batchInsert(
            MenuItem::tableName(),
            ['id', 'id_menu', 'title', 'redirect', 'position', 'placement'],
            [
                [1, 1, 'title 1', 'redirect 1', 2, MenuItem::PLACEMENT_BEFORE],
                [2, 1, 'title 2', null, 1, MenuItem::PLACEMENT_BEFORE],
                [3, 1, 'title 3', null, 3, MenuItem::PLACEMENT_AFTER],
            ]
        )->execute();
    }
}