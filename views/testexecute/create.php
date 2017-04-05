<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\teamhelper\models\Testexecute */

$this->title = 'Create Testexecute';
$this->params['breadcrumbs'][] = ['label' => 'Testexecutes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="testexecute-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
