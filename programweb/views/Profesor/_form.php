<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\publicarNotaForm */
/* @var $form yii\widgets\ActiveForm */
/* @var $idMateria */
$materia = \app\models\Materia::find()->where(['idMateria' => $idMateria])->one();
$alumnos = $materia->getAlumnos()->all();
?>

<div class="profesor-form">

    <?php $form = ActiveForm::begin(); ?>
    <h2> <?= $materia->nombre ?> </h2>
    <h3> Ciclo lectivo: <?= $materia->cicloLectivo ?> </h3>
    
    <?= $form->field($model, 'cicloLectivo')->hiddenInput(['value' => $materia->cicloLectivo])->label(false); ?>
    
    <?= $form->field($model, 'idMateria')->hiddenInput(['value' => $materia->idMateria])->label(false); ?>

    <?= $form->field($model, 'idAlumno')->dropDownList(ArrayHelper::map($alumnos, 'idalumno', 'nombre'), ['prompt' => 'Seleccione Uno'])->label('Alumno'); ?>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nota')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Publicar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
