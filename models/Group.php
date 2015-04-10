<?php

namespace app\models;


use app\components\ActiveRecord;
use app\components\ParamBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * Class Group
 * @package app\models
 *
 * @property integer $id
 * @property string $title
 * @property array $params
 */
class Group extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'ts_created',
                'updatedAtAttribute' => 'ts_updated',
            ],
            [
                'class' => ParamBehavior::className(),
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['title', 'required'],
            ['id', 'number'],
            ['title', 'string', 'min' => 2, 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeDelete()
    {
        if (parent::beforeDelete() && $this->getId() != 1) { // do not delete system admin group
                return true;
            } else {
                return false;
            }
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }
}