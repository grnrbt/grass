<?php

namespace app\components;
use yii\base\Widget;

/**
 *
 */
class BlockWidget extends Widget
{
    protected $object;
    protected $params;

    public function __construct(IObject $object, array $params = [])
    {
        $this->object = $object;
        $this->params = $params;
    }
}