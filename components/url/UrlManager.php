<?php

namespace app\components\url;

use app\models\Route;
use yii\web\NotFoundHttpException;

class UrlManager extends \yii\web\UrlManager
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        // todo maybe do not build rules, but override createUrl for dynamic url building
        $this->rules = Route::getRules();

        parent::init();
    }


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

    /**
     * @inheritdoc
     */
    /*
    public function createUrl($params)
    {
        $params = (array) $params;
        $anchor = isset($params['#']) ? '#' . $params['#'] : '';
        unset($params['#'], $params[$this->routeParam]);

        $route = trim($params[0], '/');
        unset($params[0]);

        $baseUrl = $this->getBaseUrl();

        foreach ($this->rules as $rule) {
            if (($url = $rule->createUrl($this, $route, $params)) !== false) {
                if (strpos($url, '://') !== false) {
                    if ($baseUrl !== '' && ($pos = strpos($url, '/', 8)) !== false) {
                        return substr($url, 0, $pos) . $baseUrl . substr($url, $pos);
                    } else {
                        return $url . $baseUrl . $anchor;
                    }
                } else {
                    return "$baseUrl/{$url}{$anchor}";
                }
            }
        }

        if ($this->suffix !== null) {
            $route .= $this->suffix;
        }
        if (!empty($params) && ($query = http_build_query($params)) !== '') {
            $route .= '?' . $query;
        }

        return "$baseUrl/{$route}{$anchor}";
    }
*/
}