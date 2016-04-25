<?php

namespace app\blocks;

use app\components\IObject;
use yii\base\Widget;

/**
 * Base block.
 */
abstract class Block extends Widget
{
    /** @var IObject */
    protected $object;
    /** @var array */
    protected $params;

    /** @inheritdoc */
    public function __construct(IObject $object = null, array $params = [], $config = [])
    {
        $this->object = $object;
        $this->params = $params;
        parent::__construct($config);
    }
}