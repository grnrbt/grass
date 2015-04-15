<?php

namespace app\widgets;


use yii\base\Widget;
use yii\web\View;

class CountersWidget extends Widget
{
    public function run()
    {
        \Yii::$app->view->on(View::EVENT_END_BODY, function () {
            echo $this->render('counters', ['placement' => 'bottom']);
        });

        return $this->render('counters', ['placement' => 'top']);
    }
}