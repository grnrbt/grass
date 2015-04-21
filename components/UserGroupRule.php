<?php

namespace app\components;


use Yii;
use yii\rbac\Rule;

/**
 * Checks if user group matches
 */
class UserGroupRule extends Rule
{
    public $name = 'userGroup';

    public function execute($user, $item, $params)
    {
        if (!Yii::$app->user->isGuest) {
            $group = Yii::$app->user->identity->id_group;
            if ($item->name === 'admin') {
                // todo remove group id hardcode
                return $group == 1;
            } elseif ($item->name === 'user') {
                // todo remove group id hardcode
                return $group == 1 || $group == 2;
            }
        }
        return false;
    }
}