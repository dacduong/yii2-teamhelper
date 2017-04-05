<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\teamhelper\models\Testexecutedetail */

$this->title = 'Create Testexecutedetail';
$this->params['breadcrumbs'][] = ['label' => 'Testexecutedetails', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="testexecutedetail-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
