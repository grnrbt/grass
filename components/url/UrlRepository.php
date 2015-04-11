<?php

namespace app\components\url;

use app\components\IObject;
use app\models\User;
use yii\base\Exception;

class UrlRepository implements IUrlRepository
{
    const SCENARIO_USER_CREATE = 'userCreate';
    const SCENARIO_USER_LOGIN = 'userLogin';
    const SCENARIO_USER_LOGOUT = 'userLogout';
    const SCENARIO_USER_VIEW = 'userView';

    /**
     * @inheritdoc
     */
    public function getUrlDataByObject(IObject $object, $scenario)
    {
        $className = get_class($object);
        $actionId = $this->getActionIdMap()[$className][$scenario];
        $data = [
            'objectId' => $object->getId(),
            'actionId' => $actionId,
        ];

        if ($className == User::class) {
            switch ($scenario) {
                case self::SCENARIO_USER_CREATE:
                case self::SCENARIO_USER_LOGIN:
                case self::SCENARIO_USER_LOGOUT:
                    $data['route'] = $actionId;
                    break;
                case self::SCENARIO_USER_VIEW:
                    $data['route'] = [$actionId, 'id' => $object->getId()];
                    break;
                default:
                    throw new Exception;
                    break;
            }
        }

        return new UrlData($data);
    }

    protected function getActionIdMap()
    {
        return [
            User::class => [
                self::SCENARIO_USER_CREATE => 'user/create',
                self::SCENARIO_USER_LOGIN => 'user/login',
                self::SCENARIO_USER_LOGOUT => 'user/logout',
                self::SCENARIO_USER_VIEW => 'user/view',
            ],
        ];
    }
}