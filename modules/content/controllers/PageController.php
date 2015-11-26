<?php

namespace app\modules\content\controllers;

use app\components\Controller;

class PageController extends Controller
{
    public function actionView($id)
    {
        echo $id;
    }
}