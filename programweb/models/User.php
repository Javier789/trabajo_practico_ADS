<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $idUser
 * @property string $username
 * @property string $password
 * @property string $authKey
 * @property Alumno[] $alumnos
 * @property Profesor[] $profesors
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
                [['username', 'password'], 'required'],
                [['username', 'password'], 'string', 'max' => 45],
        ];
    }

    public static function findIdentity($id) {

        $user = User::find()
                ->Where("idUser=:id", ["id" => $id])
                ->one();

        return isset($user) ? new static($user) : null;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /* Busca la identidad del usuario a travÃ©s del username */
    public static function findByUsername($username)
    {
        $user = User::find()
                ->Where("username=:username", [":username" => $username])
                ->one();
     

        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public function getId() {
        return $this->idUser;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey() {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey) {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password) {
        return $this->password === $password;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlumno() {
        return $this->hasOne(Alumno::className(), ['idUser' => 'idUser']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfesor() {
        return $this->hasOne(Profesor::className(), ['idUser' => 'idUser']);
    }

}
