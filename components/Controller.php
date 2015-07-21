<?php

namespace app\components;

use app\models\beds\BedRenderer;
use app\models\Config;
use yii\base\InvalidParamException;

abstract class Controller extends \yii\web\Controller
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
     * @param IObject|null $object = null Object for rendering.
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

        $this->setHeaders();
        return $this->render($view, $params);
    }

    public function setHeaders()
    {
        $view = $this->view;
        // default
        $view->title = Config::get('siteName');
        $view->registerMetaTag(['name' => 'keywords', 'content' => Config::get('siteKeywords')], 'keywords');
        $view->registerMetaTag(['name' => 'description', 'content' => Config::get('siteDescription')], 'description');

        // override

        // OpenGraph tags
        $view->registerMetaTag(['property' => 'og:type', 'content' => 'website'], 'og:type');
        $view->registerMetaTag(['property' => 'og:locale', 'content' => \Yii::$app->language], 'og:locale');
        $view->registerMetaTag(['property' => 'og:url', 'content' => \Yii::$app->request->absoluteUrl], 'og:url');
        $view->registerMetaTag(['property' => 'og:title', 'content' => $view->title], 'og:title');
        $view->registerMetaTag(['property' => 'og:site_name', 'content' => Config::get('siteName')], 'og:site_name');
        // todo add image
        // $view->registerMetaTag(['property' => 'og:image', 'content' => \Yii::$app->request->hostInfo . $this->image], 'og:image');
    }
}