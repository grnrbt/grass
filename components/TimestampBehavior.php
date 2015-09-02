<?php

namespace app\components;

class TimestampBehavior extends \yii\behaviors\TimestampBehavior
{
    /** @var string  */
    public $createdAtAttribute = 'ts_created';
    /** @var string  */
    public $updatedAtAttribute = 'ts_updated';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if ($this->value === null) {
            $this->value = function () { return date('Y-m-d H:i:s'); };
        }
    }
}