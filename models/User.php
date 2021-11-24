<?php

namespace app\models;

class User extends \yii\base\BaseObject implements \yii\web\IdentityInterface
{
    
    public $id;
    public $username;
    public $email;
    public $password;
    public $activate;

    /**
     * @inheritdoc
     */
    
    /* busca la identidad del usuario a través de su $id */

    public static function findIdentity($id)
    {
        
        $user = Users::find()
                ->where("activate=:activate", [":activate" => 1])
                ->andWhere("id=:id", ["id" => $id])
                ->one();
        
        return isset($user) ? new static($user) : null;
    }

    /**
     * @inheritdoc
     */
    
    /* Busca la identidad del usuario a través de su token de acceso */
    public static function findIdentityByAccessToken($token, $type = null)
    {

    }

    /* Busca la identidad del usuario a través del username */
    public static function findByUsername($username)
    {
        $users = Users::find()
                ->where("activate=:activate", ["activate" => 1])
                ->andWhere("username=:username", [":username" => $username])
                ->all();
        
        foreach ($users as $user) {
            if (strcasecmp($user->username, $username) === 0) {
                return new static($user);
            }
        }

        return null;
    }

    /* Regresa el id del usuario */
    public function getId()
    {
        return $this->id;
    }

    /* Regresa la clave de autenticación */
    public function getAuthKey()
    {
    }

    /* Valida la clave de autenticación */
    public function validateAuthKey($authKey)
    {
    }

    /**
     * Validates password
     */
    public function validatePassword($password)
    {
        /* Valida el password */
        if (crypt($password, $this->password) == $this->password)
        {
        return $password === $password;
        }
    }
}
