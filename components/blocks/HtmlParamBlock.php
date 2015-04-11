<?php

namespace app\components\blocks;

class HtmlParamBlock extends Block
{
    public function run()
    {
        echo $this->params['content'];
    }
}