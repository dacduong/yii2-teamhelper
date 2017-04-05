<?php

use app\modules\teamhelper\helpers\Helper;
use app\modules\teamhelper\models\TicketSearch;
use dacduong\inlinegrid\ActionColumn;
use dacduong\inlinegrid\DropdownlistColumn;
use dacduong\inlinegrid\HiddenInputColumn;
use dacduong\inlinegrid\Select2Column;
use dacduong\inlinegrid\TextareaColumn;
use dacduong\inlinegrid\TextInputColumn;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\web\View;
use yii\widgets\Pjax;

/* @var $this View */
/* @var $searchModel TicketSearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = 'Tickets';
$this->params['breadcrumbs'][] = ['label' => 'Teamhelper', 'url' => ['./']];
$this->params['breadcrumbs'][] = $this->title;

$textInputControlOptions = [
    'class' => 'text-right',
    'maxlength' => 5,
    'size' => 8,
    'defaultValue' => 0,
];

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
        'controlOptions' => [
            'maxlength' => 255,
            'size' => 50,
        ],
    ],
    [
        'class' => TextInputColumn::className(),
        'attribute' => 'code',
        'controlOptions' => [
            'maxlength' => 20,
            'size' => 15,
        ],
    ],
    [
        'class' => TextareaColumn::className(),
        'attribute' => 'desc',
        'vAlign' => 'top',
        'controlOptions' => [
            'maxlength' => 255,
            'rows' => 4,
            'cols' => 50
        ],
        'filter' => false,
        'mergeHeader' => true
    ],    
    [
        'class' => TextInputColumn::className(),
        'attribute' => 'estimated',
        'controlOptions' => $textInputControlOptions,
        'filter' => false,
        'mergeHeader' => true
    ],
    [
        'class' => Select2Column::className(),
        'attribute' => 'project_id',
        'modelFnc' => 'getAvailableProject',
        'controlOptions' => [
            'options' => [
                'id' => Yii::$app->security->generateRandomString(10),
                'placeholder' => 'Select Project',
                'multiple' => false,
            ],
            'pluginOptions' => [
                'ajax' => [
                    'url' => Url::to(['/teamhelper/search/team-object']),
                    'data' => new JsExpression('function(params) { return {q:params.term, type:"project"}; }'),                    
                ],
                'minimumInputLength' => 2,
                'allowClear' => true,
            ],
        ],
        'filter' => false,
        'mergeHeader' => true
    ],
    [
        'class' => Select2Column::className(),
        'attribute' => 'module_id',
        'modelFnc' => 'getAvailableModule',
        'width' => '300px',
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
            ],
        ],
        'filter' => false,
        'mergeHeader' => true
    ],
    [
        'class' => Select2Column::className(),
        'attribute' => 'phase_id',
        'modelFnc' => 'getAvailablePhase',
        'width' => '300px',
        'controlOptions' => [
            'options' => [
                'id' => Yii::$app->security->generateRandomString(10),
                'placeholder' => 'Select Phase',
                'multiple' => false,
            ],
            'pluginOptions' => [
                'ajax' => [
                    'url' => Url::to(['/teamhelper/search/team-object']),
                    'data' => new JsExpression('function(params) { return {q:params.term, type:"phase"}; }'),
                ],
                'minimumInputLength' => 2,
                'allowClear' => true,
            ],
        ],
        'filter' => false,
        'mergeHeader' => true
    ],
    [
        'class' => TextInputColumn::className(),
        'attribute' => 'url',
        'controlOptions' => [],
        'filter' => false,
        'mergeHeader' => true
    ],
    [
        'class' => DropdownlistColumn::className(),
        'attribute' => 'status',
        'data' => Helper::$statuses,
        'controlOptions' => [
            'prompt' => 'Please select',
        ],
        'filter' => Helper::$statuses,
        'filterType' => GridView::FILTER_SELECT2,
        'filterInputOptions' => ['placeholder' => 'Any status'],
        'filterWidgetOptions' => [
            'pluginOptions' => ['allowClear' => true],
        ],
    ],    
    [
        'class' => TextInputColumn::className(),
        'attribute' => 'type',
        'controlOptions' => $textInputControlOptions,
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
//    [
//        'class' => TextInputColumn::className(),
//        'attribute' => 'priority',
//        'controlOptions' => $textInputControlOptions,
//        'filter' => false,
//        'mergeHeader' => true
//    ],
];
?>
<div class="phase-index">
<?php
Pjax::begin();
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'=>$searchModel,
    'columns' => $gridColumns,
    'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
    'headerRowOptions' => ['class' => 'kartik-sheet-style'],
    'filterRowOptions' => ['class' => 'kartik-sheet-style'],
    'pjax' => true,
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
        'heading' => '<i class="glyphicon glyphicon-book"></i>  Ticket',
    ],
    'persistResize' => false,
]);
Pjax::end();
?>
</div>