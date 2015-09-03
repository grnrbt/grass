<?php

namespace app\components;

use yii\web\Controller;
use yii\web\Response;

abstract class AdminController extends Controller
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        \Yii::$app->getResponse()->format = Response::FORMAT_JSON;
    }
}