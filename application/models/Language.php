<?php

namespace app\models;

use yii\db\ActiveRecord;

class Language extends ActiveRecord
{
    /*** attributes
    @public $id;
    @public $language;
    @public $code;
     ***/
    /**
     * @inheritdoc
     */ 
    public static function tableName()
    {
        return 'languages';
    }    
}
