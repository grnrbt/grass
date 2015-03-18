<?php

namespace app\models;

use app\components\ActiveRecord;
use app\components\ParamBehavior;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;

/**
 * Class User
 * @package app\models
 *
 * @property integer $id
 * @property string $email
 * @property string $password
 * @property boolean $is_active
 * @property string $name_first
 * @property string $name_last
 * @property string $name_middle
 * @property integer $id_group
 * @property array $params
 * @property string $auth_key
 * @property string $reset_key
 */
class User extends ActiveRecord implements \yii\web\IdentityInterface
{
    public $passwordRaw;

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
            [['email', 'passwordRaw', 'id_group'], 'required'],

            [['email', 'passwordRaw', 'name_first', 'name_last', 'name_middle',], 'filter', 'filter' => 'trim'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\common\models\User'],

            ['password', 'unsafe'], // set password only directly

            ['passwordRaw', 'string', 'min' => 6],

            [['id', 'id_group'], 'number'],

            ['is_active', 'boolean'],

            [['name_first', 'name_last', 'name_middle',], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $passwordRaw
     * @return $this
     */
    public function setPassword($passwordRaw)
    {
        $this->password = \Yii::$app->security->generatePasswordHash($passwordRaw);
        $this->reset_key = null; // drop "reset password" key on password change
        return $this;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return \Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * @return boolean
     */
    public function isActive()
    {
        return $this->is_active;
    }

    /**
     * @param boolean $is_active
     * @return $this
     */
    public function setActive($is_active)
    {
        $this->is_active = $is_active;
        return $this;
    }

    /**
     * @return string
     */
    public function getNameMiddle()
    {
        return $this->name_middle;
    }

    /**
     * @return string
     */
    public function getNameFirst()
    {
        return $this->name_first;
    }

    /**
     * @param string $name_first
     * @return $this
     */
    public function setNameFirst($name_first)
    {
        $this->name_middle = $name_first;
        return $this;
    }

    /**
     * @return string
     */
    public function getNameLast()
    {
        return $this->name_last;
    }

    /**
     * @param string $name_last
     * @return $this
     */
    public function setNameLast($name_last)
    {
        $this->name_middle = $name_last;
        return $this;
    }

    /**
     * @param string $name_middle
     * @return $this
     */
    public function setNameMiddle($name_middle)
    {
        $this->name_middle = $name_middle;
        return $this;
    }

    /**
     * @return int
     */
    public function getIdGroup()
    {
        return $this->id_group;
    }

    /**
     * @param int $id_group
     * @return $this
     */
    public function setIdGroup($id_group)
    {
        $this->id_group = $id_group;
        return $this;
    }

    /**
     * @return string
     */
    public function getResetKey()
    {
        return $this->reset_key;
    }

    /**
     * @param string $reset_key
     * @return $this
     */
    public function setResetKey($reset_key)
    {
        $this->reset_key = $reset_key;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPasswordRaw()
    {
        return $this->passwordRaw;
    }

    /**
     * @param mixed $passwordRaw
     */
    public function setPasswordRaw($passwordRaw)
    {
        $this->passwordRaw = $passwordRaw;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param mixed $auth_key
     * @return $this
     */
    public function setAuthKey($auth_key)
    {
        $this->auth_key = $auth_key;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = \Yii::$app->security->generateRandomString();
    }
    /**
     * Generates new password reset key
     */
    public function generateResetKey()
    {
        $this->reset_key = \Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $resetKey password reset key
     * @return boolean
     */
    public static function validateResetKey($resetKey)
    {
        $parts = explode('_', $resetKey);
        $timestamp = (int) end($parts);
        return $timestamp + 60*60*24*30 >= time();
    }

    /**
     * Finds user by password reset key
     *
     * @param string $resetKey password reset key
     * @return static|null
     */
    public static function findByResetKey($resetKey)
    {
        if (!static::validateResetKey($resetKey)) {
            return null;
        }
        return static::findOne(['reset_key' => $resetKey,]);
    }

    /**
     * @inheritdoc
     */
    public static function find()
    {
        return parent::find()->where(['is_active' => true]);
    }

    /**
     * @inheritdoc
     */
    public function beforeDelete()
    {
        if (parent::beforeDelete() && $this->getId() != 1) { // do not delete system admin
            return true;
        } else {
            return false;
        }
    }

}
