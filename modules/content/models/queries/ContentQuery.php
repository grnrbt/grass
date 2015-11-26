<?php

namespace app\modules\content\models\queries;

use app\modules\content\models\Content;
use yii\db\ActiveQuery;

/**
 * @method Content one($db = null)
 */
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
     * @param string $slug
     * @return $this
     */
    public function bySlug($slug)
    {
        return $this->andWhere(['slug' => $slug]);
    }

    /**
     * @return $this
     */
    public function activeOnly()
    {
        return $this->andWhere(['is_active' => 1]);
    }

    /**
     * @return $this
     */
    public function visibleOnly()
    {
        return $this->andWhere(['is_hidden' => 0]);
    }
}