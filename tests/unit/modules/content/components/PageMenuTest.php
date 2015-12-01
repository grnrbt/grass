<?php

namespace app\tests\unit\modules\contents\components;

use app\modules\content\components\PageMenu;
use app\tests\unit\DbTestCase;
use app\tests\unit\fixtures\modules\content\models\ContentFixture;

class PageMenuTest extends DbTestCase
{
    public function fixtures()
    {
        return [
            ContentFixture::class,
        ];
    }

    public function testGenerate()
    {
        $result = PageMenu::generate();
        $pattern = [
            [
                'url' => '/item-5',
                'label' => 'item title 5',
            ],
            [
                'url' => '/item-1',
                'label' => 'item title 1',
            ],
        ];

        $this->assertEquals($result, $pattern);
    }
}