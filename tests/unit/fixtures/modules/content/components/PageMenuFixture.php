<?php

namespace app\tests\unit\fixtures\modules\content\components;

use app\modules\content\models\Content;
use yii\test\Fixture;

class PageMenuFixture extends Fixture
{
    public function load()
    {
        Content::deleteAll();
        \Yii::$app->getDb()->createCommand()->batchInsert(
            Content::tableName(),
            ['id', 'slug', 'is_active', 'is_hidden', 'menu_title', 'position', 'ids_bed'],
            [
                [1, 'item-1', true, false, 'item title 1', 5, '[]'],
                [2, 'item-2', false, false, 'item title 2', 2, '[]'],
                [3, 'item-3', false, true, 'item title 3', 3, '[]'],
                [4, 'item-4', true, true, 'item title 4', 4, '[]'],
                [5, 'item-5', true, false, 'item title 5', 1, '[]'],
            ]
        )->execute();
    }
}