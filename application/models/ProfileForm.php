<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Profile;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class ProfileForm extends Model
{
    public $id;
    public $username;
    public $email;    
    public $password_hash;    
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // trim values
            ['password_hash', 'filter', 'filter' => 'trim'],
            //password is required on creation 
            ['password_hash', 'required', 'on' => 'default', 'message' => 'Password is required.'],            
            // username and password must contains at least 6 characters
            ['password_hash', 'string', 'min'=>6],
            // email must be a valid address
        ];
    }
 
}
