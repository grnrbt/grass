<?php

namespace app\components;
use yii\base\InvalidConfigException;

/**
 * This trait can create controllers for block in them own directories.
 * @property string $controllerNamespace
 */
trait BlockControllerTrait
{
    /**
     * Anchor using for block controllers routing.
     * @see BlockControllerTrait::createControllerByID()
     * @var string
     */
    public static $blockUrlAnchor = 'blocks';

    /**
     * Base namespace for block controllers.
     *
     * @see self::controllerNamespace;
     * @var string
     */
    public $blockNamespace;


    /**
     * @inheritdoc
     */
    public function init()
    {
       parent::init();

        if ($this->blockNamespace === null) {
            $class = get_class($this);
            if (($pos = strrpos($class, '\\')) !== false) {
                $this->blockNamespace = substr($class, 0, $pos) . '\\blocks';
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function createControllerByID($id)
    {
        $pos = strrpos($id, '/');
        if ($pos === false) {
            $prefix = '';
            $className = $id;
        } else {
            $prefix = substr($id, 0, $pos + 1);
            $className = substr($id, $pos + 1);
        }

        $baseNamespace = $this->controllerNamespace;
        if (strpos($prefix, static::$blockUrlAnchor) === 0) {
            $baseNamespace = $this->blockNamespace;
            $prefix = substr($prefix, strlen(static::$blockUrlAnchor) + 1).$className.'/';
            $prefix = lcfirst(str_replace(' ', '', ucwords(str_replace('-', ' ', $prefix))));
        }

        if (!preg_match('%^[a-z][a-z0-9\\-_]*$%', $className)) {
            return null;
        }
        if ($prefix !== '' && !preg_match('%^[a-z0-9_/]+$%i', $prefix)) {
            return null;
        }

        $className = str_replace(' ', '', ucwords(str_replace('-', ' ', $className))) . 'Controller';
        $className = ltrim($baseNamespace . '\\' . str_replace('/', '\\', $prefix) . $className, '\\');
        if (strpos($className, '-') !== false || !class_exists($className)) {
            return null;
        }
        if (is_subclass_of($className, 'yii\base\Controller')) {
            $controller = \Yii::createObject($className, [$id, $this]);
            return get_class($controller) === $className ? $controller : null;
        } elseif (YII_DEBUG) {
            throw new InvalidConfigException("Controller class must extend from \\yii\\base\\Controller.");
        } else {
            return null;
        }
    }
}