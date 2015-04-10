<?php

namespace app\components\blocks;

use app\components\Block;

class HtmlParamBlock extends Block
{
    public function run()
    {
        echo $this->params['content'];
    }
}