<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Profesor */

$this->title = $model->idProfesor;
$this->params['breadcrumbs'][] = ['label' => 'Profesors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="profesor-view">

    <h1>Legajo <?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->idProfesor], ['class' => 'btn btn-primary']) ?>
    </p>

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
<h2>Subir notas</h2>
<?php
//$max_upload_size = multichain_max_data_size() - 512; // take off space for file name and mime type
//$allow_multi_keys = multichain_has_multi_item_keys();


?>

<div class="row">

    <div class="col-sm-12">
        <h3>Publish to Stream</h3>

        <form class="form-horizontal" method="post" enctype="multipart/form-data"  action="./?chain=<?php echo html($_GET['chain']) ?>&page=<?php echo html($_GET['page']) ?>">
            <div class="form-group">
                <label for="from" class="col-sm-2 control-label">From address:</label>
                <div class="col-sm-9">
                    <select class="form-control" name="from" id="from">
<?php
foreach ($sendaddresses as $address) {
    ?>
                            <option value="<?php echo html($address) ?>"><?php echo format_address_html($address, true, $labels) ?></option>
                            <?php
                        }
                        ?>						
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">To stream:</label>
                <div class="col-sm-9">
                    <select class="form-control" name="name" id="name">
<?php
foreach ($liststreams as $stream)
    if ($stream['name'] != 'root') {
        ?>
                                <option value="<?php echo html($stream['name']) ?>"><?php echo html($stream['name']) ?></option>
                                <?php
                            }
                        ?>						
                    </select>

                        <?php
                        if (multichain_has_off_chain_items()) {
                            ?>

                        <label class="checkbox-inline">
                            <input type="checkbox" name="offchain" value="1">Publish as off-chain item
                        </label>
    <?php
}
?>

                </div>
            </div>
            <div class="form-group">

<?php
if ($allow_multi_keys) {
    ?>

                    <label for="key" class="col-sm-2 control-label">Optional keys:</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" rows="3" name="key" id="key"></textarea>
                        <span id="helpBlock" class="help-block">To use multiple keys, enter one per line.</span>
                    </div>

    <?php
} else {
    ?>

                    <label for="key" class="col-sm-2 control-label">Optional key:</label>
                    <div class="col-sm-9">
                        <input class="form-control" name="key" id="key">
                    </div>

    <?php
}
?>

            </div>
            <div class="form-group">
                <label for="upload" class="col-sm-2 control-label">Upload file:<br/><span style="font-size:75%; font-weight:normal;">Max <?php echo floor($max_upload_size / 1024) ?> KB</span></label>
                <div class="col-sm-9">
                    <input class="form-control" type="file" name="upload" id="upload">
                </div>
            </div>

<?php
if (multichain_has_json_text_items()) {
    ?>

                <div class="form-group">
                    <label for="json" class="col-sm-2 control-label">Or JSON:</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" rows="4" name="json" id="json"></textarea>
                    </div>
                </div>

    <?php
}
?>

            <div class="form-group">
                <label for="text" class="col-sm-2 control-label">Or text:</label>
                <div class="col-sm-9">
                    <textarea class="form-control" rows="4" name="text" id="text"></textarea>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-9">
                    <input class="btn btn-default" type="submit" name="publish" value="Publish Item">
                </div>
            </div>
        </form>

    </div>
</div>