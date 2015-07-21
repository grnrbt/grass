<?php

namespace app\components\blocks;

use app\blocks\Block;

class HtmlBlock extends Block
{
    public function run()
    {
        echo $this->params['content'];
    }
}