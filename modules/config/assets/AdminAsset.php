<?php

namespace app\modules\config\assets;


use yii\web\AssetBundle;

class AdminAsset extends AssetBundle
{
    public function init()
    {
        parent::init();

        $this->sourcePath = dirname(__DIR__) . '/media';
    }
}