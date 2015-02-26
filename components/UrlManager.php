<?php

namespace app\components;

use app\models\Route;
use yii\web\NotFoundHttpException;

/**
 *
 */
class UrlManager extends \yii\web\UrlManager
{
    /**
     * @inheritdoc
     * @param Request $request
     */
    public function parseRequest($request)
    {
        $uri = $request->getPathInfo();
        /** @var Route $route */
        $route = Route::find()->andWhere(['uri' => $uri])->one();
        if (!$route) {
            throw new NotFoundHttpException;
        }

        $request->setRequestedObjectId($route->getIdObject());

        return $route->getIdAction();
    }
}