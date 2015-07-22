<?php

namespace app\modules\test\controllers;

use app\components\Controller;
use app\components\IObject;
use app\modules\test\models\beds\Bed;
use app\modules\test\models\beds\BedBlock;

class TestController extends Controller
{
    public function actionRenderTestBed($idObject = null)
    {
        $obj = new TestObject(['id' => $idObject]);
        return $this->renderBeds('test-view', $obj, ['param1' => 123]);
    }
}

class TestObject implements IObject
{
    public $id;

    public function getId()
    {
        return $this->id;
    }

    public function getBeds()
    {
        return ['mainBed' => Bed::findOne(1)];
    }
}