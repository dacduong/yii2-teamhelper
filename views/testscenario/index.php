<?php

use app\modules\teamhelper\helpers\Helper;
use app\modules\teamhelper\models\TestscenarioSearch;
use dacduong\inlinegrid\ActionColumn;
use dacduong\inlinegrid\DropdownlistColumn;
use dacduong\inlinegrid\HiddenInputColumn;
use dacduong\inlinegrid\Select2Column;
use dacduong\inlinegrid\TextareaColumn;
use dacduong\inlinegrid\TextInputColumn;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use kartik\select2\Select2;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\web\View;
use yii\widgets\Pjax;

/* @var $this View */
/* @var $searchModel TestscenarioSearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = 'Testscenarios';
$this->params['breadcrumbs'][] = ['label' => 'Teamhelper', 'url' => ['./']];
$this->params['breadcrumbs'][] = $this->title;
$gridColumns = [
        [
        'class' => SerialColumn::className(),
        'header' => 'No.',
    ],    
        [
        'class' => ActionColumn::className(),
        'width' => '100px',
        'alwaysEdit' => true,
        'actionSaveRow' => Url::to('./save-row'),
        'actionReloadRow' => Url::to('./reload-row'),
        'actionDeleteRow' => Url::to('./delete-row'),
    ],
    [
        'class' => HiddenInputColumn::className(),
        'attribute' => 'id',
        'hidden' => true,
    ],
    [
        'class' => TextInputColumn::className(),
        'attribute' => 'name',
        'controlOptions' => [],
    ],
    [
        'class' => TextInputColumn::className(),
        'attribute' => 'code',
        'controlOptions' => [],
    ],
    [
        'class' => TextareaColumn::className(),
        'attribute' => 'desc',
        'vAlign' => 'top',
        'controlOptions' => [
            'maxlength' => 255,
            'rows' => 2,
            'cols' => 20
        ],
        'filter' => false,
        'mergeHeader' => true
    ],
    [
        'class' => DropdownlistColumn::className(),
        'attribute' => 'priority',
        'data' => Helper::$priorities,
        'controlOptions' => [
            'prompt' => 'Please select',
        ],
        'filter' => Helper::$priorities,
        'filterType' => GridView::FILTER_SELECT2,
        'filterInputOptions' => ['placeholder' => 'Any priority'],
        'filterWidgetOptions' => [
            'pluginOptions' => ['allowClear' => true],
        ],
    ],
    [
        'class' => Select2Column::className(),
        'attribute' => 'ticket_id',
        'modelFnc' => 'getAvailableTicket',
        'controlOptions' => [
            'options' => [
                'id' => Yii::$app->security->generateRandomString(10),
                'placeholder' => 'Select Ticket',
                'multiple' => false,
            ],
            'pluginOptions' => [
                'ajax' => [
                    'url' => Url::to(['/teamhelper/search/team-object']),
                    'data' => new JsExpression('function(params) { return {q:params.term, type:"ticket"}; }'),
                ],
                'minimumInputLength' => 2,
                'allowClear' => true,
                'width' => '250px',
            ],
        ],
        'filter' => Select2::widget([
            'model' => $searchModel,
            'attribute' => 'ticket_id',
            'data' => $searchModel->getAvailableTicket(),
            'options' => [
                'id' => Yii::$app->security->generateRandomString(10),
                'placeholder' => 'Select Ticket',
                'multiple' => false,
            ],
            'pluginOptions' => [
                'ajax' => [
                    'url' => Url::to(['/teamhelper/search/team-object']),
                    'data' => new JsExpression('function(params) { return {q:params.term, type:"ticket"}; }'),                    
                ],
                'minimumInputLength' => 2,
                'allowClear' => true,
            ],
        ]),
    ],
    [
        'class' => Select2Column::className(),
        'attribute' => 'module_id',
        'modelFnc' => 'getAvailableModule',
        'controlOptions' => [
            'options' => [
                'id' => Yii::$app->security->generateRandomString(10),
                'placeholder' => 'Select Module',
                'multiple' => false,
            ],
            'pluginOptions' => [
                'ajax' => [
                    'url' => Url::to(['/teamhelper/search/team-object']),
                    'data' => new JsExpression('function(params) { return {q:params.term, type:"module"}; }'),                    
                ],
                'minimumInputLength' => 2,
                'allowClear' => true,
                'width' => '150px',
            ],
        ],
        'filter' => Select2::widget([
            'model' => $searchModel,
            'attribute' => 'module_id',
            'data' => $searchModel->getAvailableModule(),
            'options' => [
                'id' => Yii::$app->security->generateRandomString(10),
                'placeholder' => 'Select Module',
                'multiple' => false,
            ],
            'pluginOptions' => [
                'ajax' => [
                    'url' => Url::to(['/teamhelper/search/team-object']),
                    'data' => new JsExpression('function(params) { return {q:params.term, type:"module"}; }'),                    
                ],
                'minimumInputLength' => 2,
                'allowClear' => true,
            ],
        ]),
    ],    
];
?>
<div class="project-index">
<?php
//Pjax::begin();
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'=>$searchModel,
    'columns' => $gridColumns,
    'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
    'headerRowOptions' => ['class' => 'kartik-sheet-style'],
    'filterRowOptions' => ['class' => 'kartik-sheet-style'],
    'pjax' => false,
    // set your toolbar
    'toolbar' => [
            ['content' =>
            Html::button('<i class="glyphicon glyphicon-plus"></i>', ['type' => 'button', 'title' => 'Insert New', 'class' => 'btn btn-success', 'onclick' => 'createNewRow(this, "id");']) . ' ' .
            Html::a('<i class="glyphicon glyphicon-repeat"></i>', [""], ['data-pjax' => 0, 'class' => 'btn btn-default', 'title' => 'Reset Grid'])
        ],
        '{export}',
        '{toggleData}',
    ],
    // set export properties
    'export' => [
        'fontAwesome' => true
    ],
    // parameters from the demo form
    'bordered' => true,
    'striped' => true,
    'condensed' => true,
    'responsive' => true,
    'hover' => true,
    'showPageSummary' => true,
    'panel' => [
        'type' => GridView::TYPE_PRIMARY,
        'heading' => '<i class="glyphicon glyphicon-book"></i>  Test Scenario',
    ],
    'persistResize' => false,
]);
//Pjax::end();
?>
</div>
