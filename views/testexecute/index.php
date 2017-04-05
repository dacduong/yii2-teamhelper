<?php

use app\modules\teamhelper\helpers\Helper;
use app\modules\teamhelper\models\base\User;
use app\modules\teamhelper\models\TestexecuteSearch;
use app\modules\teamhelper\models\Testscenario;
use app\modules\teamhelper\models\Ticket;
use dacduong\inlinegrid\ActionColumn;
use dacduong\inlinegrid\DataColumn;
use dacduong\inlinegrid\DropdownlistColumn;
use dacduong\inlinegrid\HiddenInputColumn;
use dacduong\inlinegrid\Select2Column;
use dacduong\inlinegrid\SerialColumn;
use dacduong\inlinegrid\TextareaColumn;
use dacduong\inlinegrid\TextInputColumn;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\web\View;
use yii\widgets\Pjax;

/* @var $this View */
/* @var $searchModel TestexecuteSearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = 'Testexecutes';
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
        'template' => '{edit} {save} {cancel} {copy} {delete} {view}',
    ],
    [
        'class' => HiddenInputColumn::className(),
        'attribute' => 'id',
        'hidden' => true,
    ],
    [
        'class' => DataColumn::className(),
        'header' => 'Author',
        'attribute' => 'created_by',
        'value' => function($model, $key, $index) {
            $author = User::findOne($model->created_by);
            if ($author != null) {
                return $author->username;
            }
            return '';
        },
        'filter' => Select2::widget([
            'model' => $searchModel,
            'attribute' => 'created_by',
            'data' => $searchModel->getAvailableTestscenario(),
            'options' => [
                'id' => Yii::$app->security->generateRandomString(10),
                'placeholder' => 'Select Author',
                'multiple' => false,
            ],
            'pluginOptions' => [
                'ajax' => [
                    'url' => Url::to(['/teamhelper/search/user']),
                    'data' => new JsExpression('function(params) { return {q:params.term}; }'),                    
                ],
                'minimumInputLength' => 2,
                'allowClear' => true,
            ],
        ]),
    ],
    [
        'class' => DataColumn::className(),
        'header' => 'Ticket',
        'attribute' => 'ticket_id',
        'value' => function($model, $key, $index) {
            $obj = Ticket::findOne($model->ticket_id);
            if ($obj != null) {
                return $obj->name;
            }
            return '';
        },
        'filter' => Select2::widget([
            'model' => $searchModel,
            'attribute' => 'ticket_id',
            'data' => $searchModel->getAvailableTicket(),
            'options' => [
                'id' => Yii::$app->security->generateRandomString(10),
                'placeholder' => 'Select Scenario',
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
        'class' => DataColumn::className(),
        'header' => 'Test Scenario',
        'attribute' => 'testscenario_id',
        'value' => function($model, $key, $index) {
            $obj = Testscenario::findOne($model->testscenario_id);
            if ($obj != null) {
                return $obj->name;
            }
            return '';
        },
        'filter' => Select2::widget([
            'model' => $searchModel,
            'attribute' => 'testscenario_id',
            'data' => $searchModel->getAvailableTestscenario(),
            'options' => [
                'id' => Yii::$app->security->generateRandomString(10),
                'placeholder' => 'Select Scenario',
                'multiple' => false,
            ],
            'pluginOptions' => [
                'ajax' => [
                    'url' => Url::to(['/teamhelper/search/team-object']),
                    'data' => new JsExpression('function(params) { return {q:params.term, type:"testscenario"}; }'),                    
                ],
                'minimumInputLength' => 2,
                'allowClear' => true,
            ],
        ]),
    ],
    [
        'class' => Select2Column::className(),
        'attribute' => 'testcase_id',
        'modelFnc' => 'getAvailableTestcase',
        'controlOptions' => [            
            'options' => [
                'id' => Yii::$app->security->generateRandomString(10),
                'placeholder' => 'Select Test Case',
                'multiple' => false,
            ],
            'pluginOptions' => [
                'ajax' => [
                    'url' => Url::to(['/teamhelper/search/team-object']),
                    'data' => new JsExpression('function(params) { return {q:params.term, type:"testcase"}; }'),
                ],
                'minimumInputLength' => 2,
                'allowClear' => true,
                'width' => '200px',
            ],
        ],
        'filter' => Select2::widget([
            'model' => $searchModel,
            'attribute' => 'testcase_id',
            'data' => $searchModel->getAvailableTestcase(),
            'options' => [
                'id' => Yii::$app->security->generateRandomString(10),
                'placeholder' => 'Select Test Case',
                'multiple' => false,
            ],
            'pluginOptions' => [
                'ajax' => [
                    'url' => Url::to(['/teamhelper/search/team-object']),
                    'data' => new JsExpression('function(params) { return {q:params.term, type:"testcase"}; }'),                    
                ],
                'minimumInputLength' => 2,
                'allowClear' => true,
            ],
        ]),
    ],
    [
        'class' => TextInputColumn::className(),
        'attribute' => 'targetmodule',
        'controlOptions' => [],
    ],
    [
        'class' => TextInputColumn::className(),
        'attribute' => 'targetversion',
        'controlOptions' => [],
    ],
    [
        'class' => TextareaColumn::className(),
        'attribute' => 'summary',
        'vAlign' => 'top',
        'controlOptions' => [
            'maxlength' => 255,
            'rows' => 2,
            'cols' => 40
        ],
        'filter' => false,
        'mergeHeader' => true
    ],
    [
        'class' => DropdownlistColumn::className(),
        'attribute' => 'status',
        'data' => Helper::$resultStatus,
        'controlOptions' => [
            'prompt' => 'Please select',
        ],
        'filter' => Helper::$resultStatus,
        'filterType' => GridView::FILTER_SELECT2,
        'filterInputOptions' => ['placeholder' => 'Any Status'],
        'filterWidgetOptions' => [
            'pluginOptions' => ['allowClear' => true],
        ],
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
        'heading' => '<i class="glyphicon glyphicon-book"></i>  Test Execute',
    ],
    'persistResize' => false,
]);
//Pjax::end();
?>
</div>