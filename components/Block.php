<?php

namespace app\components;

use yii\base\Widget;

class Block extends Widget
{
    protected $object;
    protected $params;

    public function __construct(IObject $object, array $params = [], $config = [])
    {
        $this->object = $object;
        $this->params = $params;

        parent::__construct($config);
    }
}