<?php

namespace app\components;

class ActiveRecord extends \yii\db\ActiveRecord
{
    /**
     * @param string $value
     * @return mixed
     */
    protected function decodeJsonValue($value)
    {
        return json_decode($value, true);
    }

    /**
     * @param mixed $value
     * @return string
     */
    protected function encodeJsonValue($value)
    {
        return json_encode($value);
    }
}