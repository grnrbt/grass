<?php

namespace app\components;

use yii\web\Application;

class WebApplication extends Application
{
    use BlockControllerTrait;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->blockNamespace='app\\blocks';
    }
}