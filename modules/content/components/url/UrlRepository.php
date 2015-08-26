<?php

namespace app\modules\content\components\url;

use app\components\IObject;
use app\components\url\IUrlRepository;
use app\components\url\UrlData;
use app\modules\content\models\Content;
use yii\base\Exception;

class UrlRepository implements IUrlRepository
{
    const SCENARIO_PAGE_VIEW='view';

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

        if ($className == Content::class) {
            switch ($scenario) {
                case self::SCENARIO_PAGE_VIEW:
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
            Content::class => [
                self::SCENARIO_PAGE_VIEW => '/content/page/view',
            ],
        ];
    }
}