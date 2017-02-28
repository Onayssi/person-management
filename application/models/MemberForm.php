<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Member;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class MemberForm extends Model
{
    public $id;
    public $username;
    public $email;
    public $password_hash;
    public $role;
    public $active;
    /*
     * Scenarios
     */
    const SCENARIO_AJOUT = 'create';
    const SCENARIO_MODIFY = 'update';  
    /*
     * scenarios() method returns an array whose keys are the scenario names 
     * and values the corresponding active attributes.
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_AJOUT => ['username', 'email', 'password_hash'],
            self::SCENARIO_MODIFY => ['username', 'email'],
        ];
    }    
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // trim values
            [['username','email','password'], 'filter', 'filter' => 'trim'],
            // required fields
            [['username', 'email'], 'required'],
            //password is required on creation 
            ['password_hash', 'required', 'on' => self::SCENARIO_AJOUT, 'message' => 'Password is required.'],            
            // username and password must contains at least 6 characters
            [['username','password_hash'], 'string', 'min'=>6],
            // email must be a valid address
            ['email', 'email'],
        ];
    }
    /**
     * Sends an email with a credentials, for creation a new Member.
     *
     * @return boolean whether the email was send
     */
    public function sendEmail($data=array())
    {
        if($this->validate()){
            return \Yii::$app->mailer->compose(['html' => '@app/mail/layouts/html'], ['content' => $data["body"]])
                ->setFrom([\Yii::$app->params['adminEmail'] => \Yii::$app->name . ' Robot'])
                ->setTo($data['to'])
                ->setSubject($data['subject'] . \Yii::$app->name)
                ->send();          
        }
        return false;
    } 
}
