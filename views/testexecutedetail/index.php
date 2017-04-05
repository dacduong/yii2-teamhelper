<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\teamhelper\models\TestexecutedetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Testexecutedetails';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="testexecutedetail-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Testexecutedetail', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'teststep_id',
            'testdata',
            'expectedresult',
            'postcondition',
            // 'actualresult',
            // 'status',
            // 'notes',
            // 'testexecute_id',
            // 'team_id',
            // 'created_at',
            // 'created_by',
            // 'updated_at',
            // 'updated_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
