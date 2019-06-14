<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "materia".
 *
 * @property int $idMateria
 * @property string $nombre
 * @property int $idCurso
 * @property string $turno
 * @property int $cicloLectivo
 *
 * @property Alumnosxmateria[] $alumnosxmaterias
 * @property Alumno[] $alumnos
 * @property Curso $curso
 */
class Materia extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'materia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'idCurso', 'turno', 'cicloLectivo'], 'required'],
            [['idCurso', 'cicloLectivo'], 'integer'],
            [['nombre'], 'string', 'max' => 100],
            [['turno'], 'string', 'max' => 45],
            [['idCurso'], 'exist', 'skipOnError' => true, 'targetClass' => Curso::className(), 'targetAttribute' => ['idCurso' => 'idcurso']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idMateria' => 'Id Materia',
            'nombre' => 'Nombre',
            'idCurso' => 'Id Curso',
            'turno' => 'Turno',
            'cicloLectivo' => 'Ciclo Lectivo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlumnosxmaterias()
    {
        return $this->hasMany(Alumnosxmateria::className(), ['idMateria' => 'idmateria']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlumnos()
    {
        return $this->hasMany(Alumno::className(), ['idalumno' => 'idAlumno'])->viaTable('alumnosxmateria', ['idMateria' => 'idmateria']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurso()
    {
        return $this->hasOne(Curso::className(), ['idcurso' => 'idCurso']);
    }
}
