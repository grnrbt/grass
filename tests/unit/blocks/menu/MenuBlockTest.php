<?php

namespace app\tests\unit\blocks\menu;

use app\blocks\menu\MenuBlock;
use app\tests\unit\DbTestCase;
use app\tests\unit\fixtures\blocks\menu\MenuBlockFixture;

class MenuBlockTest extends DbTestCase
{
    public function fixtures()
    {
        return [
            MenuBlockFixture::class,
        ];
    }

    public static function fakeGenerator()
    {
        return [
            ['url' => 'fake url', 'label' => 'fake label'],
        ];
    }

    public function testRun()
    {
        $menu = new MenuBlock(null, [
            'id_menu' => 1,
            'source' => [static::class, 'fakeGenerator'],
        ]);

        $result = $menu->run();
        $pattern = [
                [
                    'label' => 'title 2',
                ],
                [
                    'label' => 'title 1',
                    'url' => 'redirect 1',
                ],
                [
                    'url' => 'fake url',
                    'label' => 'fake label',
                ],
                [
                    'label' => 'title 3',
                ],
        ];
        $this->assertEquals($result, $pattern);
    }
}