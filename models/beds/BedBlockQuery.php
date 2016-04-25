<?php

namespace app\models\beds;

use yii\db\ActiveQuery;

/**
 * @method BedBlock one($db = null)
 * @method BedBlock[] all($db = null)
 */
class BedBlockQuery extends ActiveQuery
{
    /**
     * Filter by `is_active` field.
     *
     * @param bool $active = true
     * @return $this
     */
    public function active($active = true)
    {
        return $this->andWhere(['is_active' => $active]);
    }
}