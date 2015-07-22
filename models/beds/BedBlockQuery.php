<?php

namespace app\models\beds;

use yii\db\ActiveQuery;

class BedBlockQuery extends ActiveQuery
{
    /**
     * Return only blocks with $is_active == true.
     *
     * @return $this
     */
    public function activeOnly()
    {
        return $this->andWhere(['is_active' => true]);
    }

}