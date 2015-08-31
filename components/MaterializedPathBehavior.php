<?php

namespace app\components;

use yii\base\Behavior;
use yii\db\ActiveQuery;

/**
 * Behavior for materializePath in ActiveRecord models.
 * It uses postgreSQL arrays for path field.
 *
 * @method static ActiveQuery find();
 */
class MaterializedPathBehavior extends Behavior
{
    /** @var MaterializedPathBehavior[] */
    protected $children = [];
    /** @var bool */
    protected $isChildrenLoaded = false;
    /** @var MaterializedPathBehavior[] */
    protected $parents = [];
    /** @var bool */
    protected $isParentsLoaded = false;

    /** @var string */
    public $depthField = 'depth';
    /** @var string */
    public $pkField;
    /** @var string */
    public $pathField = 'path';
    /** @var string */
    public $positionField = 'position';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if ($this->pkField === null) {
            $this->pkField = $this->primaryKey();
        }
    }

    /**
     * @param bool $force = false
     * @return MaterializedPathBehavior[]
     */
    public function getParents($force = false)
    {
        if (!$this->isParentsLoaded || $force) {
            $path = $this->getPath();
            $pks = array_slice($path, 0, count($path) - 1);
            $this->parents = static::find()
                ->andWhere([$this->pkField => $pks])
                ->orderBy([$this->depthField => SORT_ASC])
                ->asArray()
                ->all();

            $this->isParentsLoaded = true;
        }

        return $this->parents;
    }

    /**
     * @param bool $force = false
     * @return MaterializedPathBehavior[]
     */
    public function getChildren($force = false)
    {
        if (!$this->isChildrenLoaded || $force) {
            /** @var MaterializedPathBehavior[] $records */
            $records = $this->find()
                ->andWhere("{$this->pathField} && array[" . $this->{$this->pkField} . "]")
                ->andWhere(['>', $this->depthField, $this->{$this->depthField}])
                ->orderBy([$this->depthField => SORT_ASC, $this->positionField => SORT_ASC])
                ->all();

            foreach ($records as $record) {
                $this->addChild($record);
            }

            $this->isChildrenLoaded = true;
        }

        return $this->children;
    }

    /**
     * Returns where current node is parent of {$node}.
     *
     * @param MaterializedPathBehavior $node
     * @param bool $prevLevelOnly = true
     * @return bool
     */
    public function isParentOf($node, $prevLevelOnly = true)
    {
        if ($node->{$this->pkField} == $this->{$this->pkField}) {
            return false;
        }

        return $prevLevelOnly
            ? $node->getPath()[$node->{$this->depthField} - 2] == $this->{$this->pkField}
            : in_array($this->{$this->pkField}, $node->getPath()[$this->{$this->depthField}]);
    }

    /**
     * Returns where current node is child of {$node}.
     *
     * @param MaterializedPathBehavior $node
     * @param bool $nextLevelOnly = true
     * @return bool
     */
    public function isChildOf($node, $nextLevelOnly = true)
    {
        if ($node->{$this->pkField} == $this->{$this->pkField}) {
            return false;
        }

        return $nextLevelOnly
            ? $node->getPath()[$this->{$node->depthField} - 2] == $node->{$node->pkField}
            : in_array($node->{$node->pkField}, $this->getPath()[$node->{$node->depthField}]);
    }

    /**
     * @return bool
     */
    public function isRoot()
    {
        return $this->{$this->depthField} == 1;
    }

    /**
     * Set current node as child of {$node}
     *
     * @param MaterializedPathBehavior $node
     * @param $node
     * @return $this
     */
    public function appendTo($node)
    {
        // TODO: realize
    }

    /**
     * @param MaterializedPathBehavior $node
     */
    protected function addChild($node)
    {
        if ($this->isParentOf($node)) {
            $this->children[] = $node;
        } else {
            foreach ($this->children as $children) {
                if ($children->isParentOf($node, false)) {
                    $children->addChild($node);
                }
            }
        }
    }

    protected function getPath()
    {
        return str_getcsv(trim($this->{$this->pathField}, '{}'));
    }
}