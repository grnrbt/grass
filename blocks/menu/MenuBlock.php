<?php

namespace app\blocks\menu;

use app\blocks\Block;
use app\models\MenuItem;

class MenuBlock extends Block
{
    protected $idMenu;
    protected $source;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->idMenu = $this->params['id_menu'];
        $this->source = $this->params['source'];
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        /** @var MenuItem[] $menuItems */
        $menuItems = MenuItem::find()
            ->andWhere(['id_menu' => $this->idMenu])
            ->orderBy(['placement' => SORT_ASC, 'position' => SORT_ASC])
            ->each();

        $generateItems = call_user_func($this->source);

        $result = [];
        $lastPlacement = MenuItem::PLACEMENT_BEFORE;
        foreach ($menuItems as $item) {
            if ($lastPlacement != $item->getPlacement()) {
                $result = array_merge($result, $generateItems);
            }
            $result[] = $this->convertItem($item);
            $lastPlacement = $item->getPlacement();
        }

        return $result;
    }

    /**
     * @param MenuItem $item
     * @return array
     */
    protected function convertItem(MenuItem $item)
    {
        $result=['label'=>$item->getTitle()];
        if($item->getRedirect()){
            $result['url']=$item->getRedirect();
        }

        return $result;
    }
}