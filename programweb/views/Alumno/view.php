<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $alumno app\models\Alumno */

$this->title = $alumno->idalumno;
$this->params['breadcrumbs'][] = ['label' => 'Alumnos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="alumno-view">

    <h1> Legajo <?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $alumno->idalumno], ['class' => 'btn btn-primary']) ?>
    </p>

    <?=
    DetailView::widget([
        'model' => $alumno,
        'attributes' => [
                [
                'value' => function ($model) {
                    return $model->idalumno;
                },
                'label' => 'legajo'
            ],
            'nombre',
            'apellido'
        ],
    ])
    ?>
</div>
<h2>Mis Materias</h2>
    <?= GridView::widget([
        'dataProvider' => $materias,
        'columns' => [
            'nombre',
            'cicloLectivo',
            'turno',
            [
            'class' => 'yii\grid\ActionColumn',
            'template' => ' {myButton}',  // the default buttons + your custom button
            'buttons' => [
                'myButton' => function($url, $model) {     // render your custom button
                    return Html::a('ver notas', '?r=alumno/notas&idMateria='.$model->idMateria.'&idAlumno='.$this->title.'&ciclo='.$model->cicloLectivo);
                }
            ]
        ]
        ]
    ]); ?>