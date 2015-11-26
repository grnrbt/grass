<?php

namespace app\models\queries;

use app\models\Route;
use yii\db\ActiveQuery;

/**
 * @method Route one($db = null)
 */
class RouteQuery extends ActiveQuery
{
    public function byUri($uri)
    {
        return $this->andWhere(['uri' => $uri]);
    }
}