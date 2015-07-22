<?php

namespace app\models\beds;

use app\blocks\Block;
use app\components\IObject;

class BedRenderer
{
    protected $bed;
    protected $object;
    protected $blocks;
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
            foreach ($this->getBlocks() as $block) {
                $renderBuffer[] = $block->run();
            }
            $this->renderBuffer = implode('', $renderBuffer);
        }
        return $this->renderBuffer;
    }

    /**
     * @return Block[]
     */
    protected function getBlocks()
    {
        if ($this->blocks === null) {
            foreach ($this->bed->getBlocks()->activeOnly()->each() as $block) {
                $class = $block->getSource();
                $this->blocks[] = new $class($this->object, $block->getParams());
            }
        }

        return $this->blocks;
    }

}