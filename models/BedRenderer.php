<?php

namespace app\models;

use app\components\Block;
use app\components\IObject;

class BedRenderer
{
    protected $bed;
    protected $object;
    protected $widgets = [];
    protected $renderBuffer;

    public function __construct(Bed $bed, IObject $object)
    {
        $this->bed = $bed;
        $this->object = $object;
    }

    public function __toString()
    {
        return $this->getRenderBuffer();
    }

    public function render()
    {
        echo $this->getRenderBuffer();
    }

    /**
     * @return string
     */
    protected function getRenderBuffer()
    {
        if ($this->renderBuffer === null) {
            $renderBuffer = [];
            foreach ($this->getWidgets() as $widget) {
                $renderBuffer[] = $widget->run();
            }
            $this->renderBuffer = implode('', $renderBuffer);
        }
        return $this->renderBuffer;
    }

    /**
     * @return Block[]
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