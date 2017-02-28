<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Person;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class PersonForm extends Model
{
    public $id;
    public $first_name;
    public $last_name;
    public $mobile;
    public $email;
    public $lang;
    public $date_of_birth;
    /*
     * Scenarios
     */
    const SCENARIO_AJOUT = 'create';
    const SCENARIO_MODIFY = 'update';    
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // required fields
            [['first_name', 'last_name','mobile','email','date_of_birth'], 'required'],
            // first name and last name must contains at least two characters
            [['first_name','last_name'], 'string', 'min'=>2],
            // email must be a valid address
            ['email', 'email'],
            // mobile is validated by isNumericValue()
            ['mobile', 'isNumericValue'],
            // date of birth is validated by isValidDoB()
            ['date_of_birth', 'isValidDoB'],
        ];
    }
    /**
     * validate a numeric value for the mobile number
     * @return boolean
     */
    public function isNumericValue($attribute)
    {
        if (!preg_match('/^[0-9]{10,20}$/', $this->$attribute)) {
            $this->addError($attribute, 'Field must contain exactly minimum 10 digits and maximum 20 digits!');
        }
    }
    /**
     * validate a date value for the date of birth value
     * @return boolean
     */
    public function isValidDoB($attribute)
    {
        $format = explode("-",$this->$attribute);
        if(count($format)!==3){
            $this->addError($attribute, 'Invalid date of birth value!');
        }else if(!is_numeric($format[0]) || !is_numeric($format[1])){
            $this->addError($attribute, 'Invalid date of birth format!');
        }else if (strtotime($this->$attribute)>=strtotime('today')){
            $this->addError($attribute, 'Date of birth value must be lesser than today!');
        }
    }  
}
