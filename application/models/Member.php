<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class Member extends ActiveRecord implements IdentityInterface
{
    /*** attributes
    @public $id;
    @public $username;
    @public $email;
    @public $password_hash;
    @public $active;
     ***/  
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;    
    /**
     * @inheritdoc
     */ 
    public static function tableName()
    {
        return 'members';
    } 
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }
    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }
    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }
    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }
    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
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
    /*
     * Custom method for username availability (unique)
     */
    public function isUniqueUsername($id,$username,$model){
        $user = self::find()->where('username = :username and id != :id', ['username' => $username, 'id' => $id])->all();
        if ($user) {
            $model->addError('username', 'Username entered is already exist. It must be unique! Please, provide another one.'); 
            return false;
        }
        return true;
    }     
    /*
     * Custom method for email availability (unique)
     */
    public function isUniqueEmail($id,$email,$model){
        $user = self::find()->where('email = :email and id != :id', ['email' => $email, 'id' => $id])->all();
        if ($user) {
            $model->addError('email', 'Email address entered is already exist! It must be unique. Please, provide another one.'); 
            return false;
        }
        return true;
    }    
}
