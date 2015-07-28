<?php

namespace app\components;

use yii\db\ActiveQuery;

/**
 * @property int $id
 * @property string $path
 * @property int $depth
 * @property int $position
 * @method static ActiveQuery find();
 */
trait MaterializedPathTrait
{
    /** @var MaterializedPathTrait[] */
    private $children = [];
    private $isChildrenLoaded = false;
    /** @var MaterializedPathTrait[] */
    private $parents = [];
    private $isParentsLoaded = false;

    /**
     * @param bool $force = false
     * @return MaterializedPathTrait[]
     */
    public function getParents($force = false)
    {
        if (!$this->isParentsLoaded || $force) {
            $path = $this->getPath();
            $ids = array_slice($path, 0, count($path) - 1);
            $this->parents = static::find()
                ->andWhere(['id' => $ids])
                ->orderBy(['depth' => SORT_ASC])
                ->asArray()
                ->all();

            $this->isParentsLoaded = true;
        }

        return $this->parents;
    }

    /**
     * @param bool $force = false
     * @return MaterializedPathTrait[]
     */
    public function getChildren($force = false)
    {
        if (!$this->isChildrenLoaded || $force) {
            /** @var MaterializedPathTrait[] $records */
            $records = $this->find()
                ->andWhere('path && array[' . $this->id . ']')
                ->andWhere(['>', 'depth', $this->depth])
                ->orderBy(['depth' => SORT_ASC, 'position' => SORT_ASC])
                ->all();

            foreach ($records as $record) {
                $this->addChild($record);
            }

            $this->isChildrenLoaded = true;
        }

        return $this->children;
    }

    /**
     * @param MaterializedPathTrait $node
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

    /**
     * @param MaterializedPathTrait $node
     * @param bool $prevLevelOnly = true
     * @return bool
     */
    public function isParentOf($node, $prevLevelOnly = true)
    {
        if ($node->id == $this->id) {
            return false;
        }

        return $prevLevelOnly
            ? $node->getPath()[$node->depth - 2] == $this->id
            : $node->getPath()[$this->depth - 1] == $this->id;
    }

    public function isRoot()
    {
        return $this->depth == 1;
    }

    public function getPath()
    {
        return str_getcsv(trim($this->path, '{}'));
    }

    /**
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @return int
     */
    public function getDepth()
    {
        return $this->depth;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}