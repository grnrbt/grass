<?php

namespace app\blocks\html;

use app\blocks\Block;

class HtmlBlock extends Block
{
    public function run()
    {
        echo $this->params['content'];
    }
}