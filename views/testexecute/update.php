<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\teamhelper\models\Testexecute */

$this->title = 'Update Testexecute: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Teamhelper', 'url' => ['./']];
$this->params['breadcrumbs'][] = ['label' => 'Testexecutes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="testexecute-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
