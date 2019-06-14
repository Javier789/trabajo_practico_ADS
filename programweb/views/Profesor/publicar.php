<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PublicarNotaForm */
/* @var $idMateria */

$this->title = 'Publicar nota';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profesor-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'idMateria' => $idMateria
    ]) ?>

</div>
