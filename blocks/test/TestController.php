<?php

namespace app\blocks\test;

use app\blocks\BlockController;

class TestController extends BlockController
{
    public function actionTestView()
    {
        echo "Block controller is running!";
    }
}