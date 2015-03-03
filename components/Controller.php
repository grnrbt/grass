<?php

namespace app\components;

use app\models\BedRenderer;
use yii\base\InvalidParamException;

/**
 *
 */
class Controller extends \yii\web\Controller
{
    const BEDS_PARAMS_INDEX = 'beds';

    /**
     * Generates bedBuilders for {$object} and puts them into view.
     * BedRenderer will be in view in {self::BEDS_PARAMS_INDEX} variable.
     * $beds = [
     *   'sidebar' => // BedRenderer for sidebar bed,
     * ]
     *
     * @param string $view {@see self::render()}.
     * @param IObject $object = null Object for rendering.
     * @param array $params
     * @return string
     */
    public function renderBeds($view, IObject $object = null, array $params = [])
    {
        if ($object) {
            if (isset($params[self::BEDS_PARAMS_INDEX])) {
                throw new InvalidParamException(\Yii::t(
                    'errors',
                    'Index "{0}" is already exist in $params argument',
                    self::BEDS_PARAMS_INDEX
                ));
            }

            foreach ($object->getBeds() as $name => $bed) {
                $params[self::BEDS_PARAMS_INDEX][$name] = new BedRenderer($bed, $object);

            }
        }

        return $this->render($view, $params);
    }
}