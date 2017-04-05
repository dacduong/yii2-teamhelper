<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\teamhelper\models\Testexecutedetail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="testexecutedetail-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'teststep_id')->textInput() ?>

    <?= $form->field($model, 'testdata')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'expectedresult')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'postcondition')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'actualresult')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'notes')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'testexecute_id')->textInput() ?>

    <?= $form->field($model, 'team_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
