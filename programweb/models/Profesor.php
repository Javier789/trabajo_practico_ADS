<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "profesor".
 *
 * @property int $idProfesor
 * @property string $nombre
 * @property string $apellido
 * @property int $idUser
 *
 * @property User $user
 * @property Profesoresxmateria[] $profesoresxmaterias
 */
class Profesor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profesor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'apellido', 'idUser'], 'required'],
            [['idUser'], 'integer'],
            [['nombre', 'apellido'], 'string', 'max' => 100],
            [['idUser'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['idUser' => 'iduser']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idProfesor' => 'Id Profesor',
            'nombre' => 'Nombre',
            'apellido' => 'Apellido',
            'idUser' => 'Id User',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['iduser' => 'idUser']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfesoresxmaterias()
    {
        return $this->hasMany(Profesoresxmateria::className(), ['idProfesor' => 'idprofesor']);
    }
}
