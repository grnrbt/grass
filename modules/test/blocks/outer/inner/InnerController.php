<?php

namespace app\modules\test\blocks\outer\inner;

use app\blocks\BlockController;

class InnerController extends BlockController
{
    public function actionTestView()
    {
        echo "Inner block controller (in module) is running!";
    }
}