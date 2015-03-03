<?php

namespace app\components;
use yii\base\InvalidParamException;

/**
 *
 */
class Controller extends \yii\web\Controller
{
    const BEDS_PARAMS_INDEX = 'beds';

    /**
     * Generates beds for {$object}+{$view} and puts them into view.
     *
     * @param string $view {@see self::render()}.
     * @param IObject $object = null Object for rendering.
     * @param array $params
     * @return string
     */
    public function renderBeds($view, IObject $object = null, array $params = [])
    {
        if ($object) {
            if (isset($object[self::BEDS_PARAMS_INDEX])) {
                throw new InvalidParamException(\Yii::t(
                    'errors',
                    'Index "{0}" is already exist in $params argument',
                    self::BEDS_PARAMS_INDEX
                ));
            }
            $params[self::BEDS_PARAMS_INDEX] = $object->getBeds();
        }

        return $this->render($view, $params);
    }
}