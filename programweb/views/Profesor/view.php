<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $model app\models\Profesor */

$this->title = $model->idProfesor;
$this->params['breadcrumbs'][] = ['label' => 'Profesors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="profesor-view">

    <h1>Legajo <?= Html::encode($this->title) ?></h1>


    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'nombre',
            'apellido',
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
                    return Html::a('Subir notas', '?r=profesor/publicar&idMateria='.$model->idMateria);
                }
            ]
        ]
        ]
    ]); ?>
