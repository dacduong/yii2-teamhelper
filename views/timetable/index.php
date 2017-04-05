<?php

use app\modules\teamhelper\models\TimetableSearch;
use dacduong\inlinegrid\ActionColumn;
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

/* @var $this View */
/* @var $searchModel TimetableSearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = 'Timetables';
$this->params['breadcrumbs'][] = ['label' => 'Teamhelper', 'url' => ['./']];
$this->params['breadcrumbs'][] = $this->title;

$textInputControlOptions = [
    'class' => 'text-right',
    'maxlength' => 4,
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
        'pageSummary' => 'Total',
    ],
    [
        'class' => HiddenInputColumn::className(),
        'attribute' => 'id',
        'hidden' => true,
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
                'width' => '300px',
            ],
        ],
        'pageSummary' => true,
        'pageSummaryFunc' => GridView::F_COUNT,
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
        'class' => TextInputColumn::className(),
        'attribute' => 'day0',
        'format' => ['decimal', 1],
        'pageSummary' => true,
        'controlOptions' => $textInputControlOptions,
        'filter' => false,
        'mergeHeader' => true,
        'hAlign' => GridView::ALIGN_RIGHT,
    ],
    [
        'class' => TextInputColumn::className(),
        'attribute' => 'day1',
        'format' => ['decimal', 1],
        'pageSummary' => true,
        'controlOptions' => $textInputControlOptions,
        'filter' => false,
        'mergeHeader' => true,
        'hAlign' => GridView::ALIGN_RIGHT,
    ],
    [
        'class' => TextInputColumn::className(),
        'attribute' => 'day2',
        'format' => ['decimal', 1],
        'pageSummary' => true,
        'controlOptions' => $textInputControlOptions,
        'filter' => false,
        'mergeHeader' => true,
        'hAlign' => GridView::ALIGN_RIGHT,
    ],
    [
        'class' => TextInputColumn::className(),
        'attribute' => 'day3',
        'format' => ['decimal', 1],
        'pageSummary' => true,
        'controlOptions' => $textInputControlOptions,
        'filter' => false,
        'mergeHeader' => true,
        'hAlign' => GridView::ALIGN_RIGHT,
    ],
    [
        'class' => TextInputColumn::className(),
        'attribute' => 'day4',
        'format' => ['decimal', 1],
        'pageSummary' => true,
        'controlOptions' => $textInputControlOptions,
        'filter' => false,
        'mergeHeader' => true,
        'hAlign' => GridView::ALIGN_RIGHT,
    ],
    [
        'class' => TextareaColumn::className(),
        'attribute' => 'remark',
        'vAlign' => 'top',
        'controlOptions' => [
            'maxlength' => 255,
            'rows' => 2,
            'cols' => 40
        ],
        'filter' => false,
        'mergeHeader' => true
    ],
//    [
//        'class' => TextInputColumn::className(),
//        'attribute' => 'day5',
//        'pageSummaryFunc' => GridView::F_MAX,
//        'format' => ['decimal', 1],
//        'pageSummary' => true,
//        'controlOptions' => $textInputControlOptions,
//        'filter' => false,
//        'mergeHeader' => true,
//        'hAlign' => GridView::ALIGN_RIGHT,
//    ],
//    [
//        'class' => TextInputColumn::className(),
//        'attribute' => 'day6',
//        'pageSummaryFunc' => GridView::F_MAX,
//        'format' => ['decimal', 1],
//        'pageSummary' => true,
//        'controlOptions' => $textInputControlOptions,
//        'filter' => false,
//        'mergeHeader' => true,
//        'hAlign' => GridView::ALIGN_RIGHT,
//    ],
];

$userQuery = '';
if (isset($_GET['id'])) {
    $userQuery .= '&id='.$_GET['id'];
}

?>
<div class="project-index">
    <p class="pull-right">
        <?= Html::a('< Previous', ["index?week=$previousDate".$userQuery], ['class' => '']) ?>
        From: <?= $fromStr ?> -- To <?= $toStr ?>
        <?= Html::a('Next >', ["index?week=$nextDate".$userQuery], ['class' => '']) ?>
    </p>
    <div class="clearfix"></div>
<?php
//Pjax::begin();
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'=>$searchModel,
    'columns' => $gridColumns,
    'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
    'headerRowOptions' => ['class' => 'kartik-sheet-style'],
    'filterRowOptions' => ['class' => 'kartik-sheet-style'],
    //'pjax' => true,
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
        'heading' => '<i class="glyphicon glyphicon-book"></i>  Timetable',
    ],
    'persistResize' => false,
]);
//Pjax::end();
?>
</div>