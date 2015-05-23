<?php

namespace app\components;


use app\models\Config;
use yii\base\Component;

class Init extends Component
{
    public function init()
    {
        parent::init();

        Config::loadCache();
    }

}