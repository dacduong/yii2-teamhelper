<?php

use app\modules\teamhelper\helpers\Helper;
use app\modules\teamhelper\models\Testexecute;
use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\web\View;

/* @var $this View */
/* @var $model Testexecute */
/* @var $form ActiveForm */
?>

<div class="testexecute-form">

    <?php $form = ActiveForm::begin([
            'layout' => 'horizontal',
        ]); ?>
    <div class="row">
        <div class="col-md-8">
            <?= $form->field($model, 'testcase_id')->widget(Select2::className(), [
                'data'      => $model->getAvailableTestcase(),
                'options'   => [
                    'placeholder' => 'Select Test Case',
                    'multiple' => false,
                ],
                'pluginOptions' => [
                    'ajax' => [
                        'url'  => Url::to(['/teamhelper/search/team-object']),
                        'data' => new JsExpression('function(params) { return {q:params.term, type:"testcase"}; }'),
                    ],
                    'minimumInputLength' => 2,
                    'allowClear' => true,
                ],
            ]) ?>
            <?= $form->field($model, 'status')->dropDownList(Helper::$resultStatus) ?>
            <?= $form->field($model, 'summary')->textarea(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'targetmodule')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'targetversion')->textInput(['maxlength' => true]) ?>
        </div>        
    </div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
