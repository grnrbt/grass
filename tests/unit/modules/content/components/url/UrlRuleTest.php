<?php

namespace app\tests\unit\modules\content\components\url;

use app\modules\content\components\UrlRule;
use app\modules\content\models\Content;
use app\tests\unit\DbTestCase;
use app\tests\unit\fixtures\modules\content\models\ContentFixture;
use ReflectionClass;

/**
 * @method Content content($id)
 */
class UrlRuleTest extends DbTestCase
{
    public function fixtures()
    {
        return [
            'content' => ContentFixture::class,
        ];
    }

    public function testGenerateRouteByUri()
    {
        $record = $this->content(1);
        $uri = $record->getSlug();
        $method = static::getMethod('generateRouteByUri');
        $route = $method->invokeArgs(new UrlRule(), [$uri]);
        $pattern = ['/content/page/view', ['id' => $record->getId()]];
        $this->assertEquals($pattern, $route);
    }

    public function testGenerateUriByRoute()
    {
        $record = $this->content(1);
        $route = 'content/page/view';
        $params=['id'=>$record->getId()];
        $method = static::getMethod('generateUriByRoute');
        $uri = $method->invokeArgs(new UrlRule(), [$route,$params]);
        $pattern =  $record->getSlug();
        $this->assertEquals($pattern, $uri);
    }

    private static function getMethod($name)
    {
        $class = new ReflectionClass(UrlRule::class);
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method;
    }
}