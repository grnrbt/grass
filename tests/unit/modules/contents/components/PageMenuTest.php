<?php

namespace app\tests\unit\modules\contents\components;

use app\modules\content\components\PageMenu;
use app\tests\unit\DbTestCase;
use app\tests\unit\fixtures\modules\content\components\PageMenuFixture;

class PageMenuTest extends DbTestCase
{
    public function fixtures()
    {
        return [
            PageMenuFixture::class,
        ];
    }

    public function testGenerate()
    {
        $result = PageMenu::generate();
        $pattern = [
            [
                'url' => '/content/page/view?id=5',
                'label' => 'item title 5',
            ],
            [
                'url' => '/content/page/view?id=1',
                'label' => 'item title 1',
            ],
        ];

        $this->assertEquals($result, $pattern);
    }
}