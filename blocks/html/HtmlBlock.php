<?php

namespace app\blocks\html;

use app\blocks\Block;

/**
 * Html block.
 * Contains plain html code.
 * params:
 * - content string Html content.
 */
class HtmlBlock extends Block
{
    /** @inheritdoc */
    public function run()
    {
        return $this->params['content'];
    }
}