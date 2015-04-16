<?php

namespace app\widgets;


use yii\base\Widget;

class AdminLinkWidget extends Widget
{
    public function run()
    {
        if(\Yii::$app->user->getIdentity()->isAdmin()){
            return $this->render('admin-link');
        }
    }
}