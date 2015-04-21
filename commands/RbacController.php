<?php
namespace app\commands;

use app\components\UserGroupRule;
use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        $rule = new UserGroupRule();
        $auth->add($rule);

        $author = $auth->createRole('user');
        $author->ruleName = $rule->name;
        $auth->add($author);

        $admin = $auth->createRole('admin');
        $admin->ruleName = $rule->name;
        $auth->add($admin);
        $auth->addChild($admin, $author);

    }
}