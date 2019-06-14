<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "alumno".
 *
 * @property int $idalumno
 * @property string $nombre
 * @property string $apellido
 * @property int $idUser
 *
 * @property User $user
 * @property Alumnosxmateria[] $alumnosxmaterias
 * @property Materia[] $materias
 */
class Alumno extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'alumno';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'apellido'], 'required'],
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
            'idalumno' => 'Idalumno',
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
    public function getAlumnosxmaterias()
    {
        return $this->hasMany(Alumnosxmateria::className(), ['idAlumno' => 'idalumno']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterias()
    {
        return $this->hasMany(Materia::className(), ['idmateria' => 'idMateria'])->viaTable('alumnosxmateria', ['idAlumno' => 'idalumno']);
    }
}
