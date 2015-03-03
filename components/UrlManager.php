<?php

namespace app\components;

use app\models\Route;
use yii\web\NotFoundHttpException;

class UrlManager extends \yii\web\UrlManager
{
    /**
     * @inheritdoc
     */
    public function parseRequest($request)
    {
        $uri = $request->getPathInfo();
        /** @var Route $route */
        $route = Route::find()->andWhere(['uri' => $uri])->one();
        if (!$route) {
            throw new NotFoundHttpException;
        }

        if ($route->getIdObject()) {
            $_GET['idObject'] = $route->getIdObject();
        }

        return [$route->getIdAction(), []];
    }
}