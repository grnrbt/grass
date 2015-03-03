<?php

namespace app\models;

use app\components\BlockWidget;
use app\components\IObject;

/**
 *
 */
class BedRenderer
{
    protected $bed;
    protected $object;
    protected $widgets = [];
    protected $renderStr;

    public function __construct(Bed $bed, IObject $object)
    {
        $this->bed = $bed;
        $this->object = $object;
    }

    public function __toString()
    {
        return $this->getRenderStr();
    }

    public function render()
    {
        echo $this->getRenderStr();
    }

    /**
     * @return string
     */
    protected function getRenderStr()
    {
        if ($this->renderStr === null) {
            $this->renderStr = '';
            foreach ($this->getWidgets() as $widget) {
                $this->renderStr .= $widget->run();
            }
        }
        return $this->renderStr;
    }

    /**
     * @return BlockWidget[]
     */
    protected function getWidgets()
    {
        if ($this->widgets === null) {
            foreach ($this->bed->enabledBlocks as $block) {
                $class = $block->getWidgetClass();
                $this->widgets[] = new $class($this->object, $block->getParams());
            }
        }

        return $this->widgets;
    }

}