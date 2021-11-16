<?php

namespace app\models;
use Yii;
use yii\db\ActiveRecord;

class Users extends ActiveRecord{
    public static function tableName()
    {
        return 'users';
    }
    
}