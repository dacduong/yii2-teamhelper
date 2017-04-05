<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\teamhelper\models\TestexecutedetailSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="testexecutedetail-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'teststep_id') ?>

    <?= $form->field($model, 'testdata') ?>

    <?= $form->field($model, 'expectedresult') ?>

    <?= $form->field($model, 'postcondition') ?>

    <?php // echo $form->field($model, 'actualresult') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'notes') ?>

    <?php // echo $form->field($model, 'testexecute_id') ?>

    <?php // echo $form->field($model, 'team_id') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
