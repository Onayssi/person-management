<?php

namespace app\models;

use yii\db\ActiveRecord;
use app\models\Language;

class Person extends ActiveRecord
{
    /*** attributes
    @public $id;
    @public $first_name;
    @public $last_name;
    @public $mobile;
    @public $email;
    @public $lang;
    @public $date_of_birth;
     ***/    
    /**
     * @inheritdoc
     */ 
    public static function tableName()
    {
        return 'persons';
    } 
    /*
     * Languages list (relation management)
     */
    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'lang']);
    }
    /*
     * Custom method for email availability (unique)
     */
    public function isUniqueEmail($id,$email,$personForm){
        $user = self::find()->where('email = :email and id != :id', ['email' => $email, 'id' => $id])->all();
        if ($user) {
            $personForm->addError('email', 'Email address entered is already exist! Please, provide another one.'); 
            return false;
        }
        return true;
    }    
}
