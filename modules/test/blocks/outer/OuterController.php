<?php

namespace app\modules\test\blocks\outer;

use app\blocks\BlockController;

class OuterController extends BlockController
{
    public function actionTestView()
    {
        echo "Outer block controller is running!";
    }
}