<?php

namespace app\modules\content\models;

use yii\db\ActiveQuery;

class ContentQuery extends ActiveQuery
{
    /**
     * @param int $id
     * @return $this
     */
    public function byId($id)
    {
        return $this->andWhere(['id' => $id]);
    }

    /**
     * @return $this
     */
    public function activeOnly()
    {
        return $this->andWhere(['is_active' => true]);
    }

    /**
     * @return $this
     */
    public function visibleOnly()
    {
        return $this->andWhere(['is_hidden' => false]);
    }
}