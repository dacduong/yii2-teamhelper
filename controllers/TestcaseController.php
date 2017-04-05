<?php

namespace app\modules\teamhelper\controllers;

use app\modules\teamhelper\models\Testcase;
use app\modules\teamhelper\models\TestcaseSearch;
use app\modules\teamhelper\models\Testscenario;
use dacduong\inlinegrid\EmptyDataProvider;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * TestcaseController implements the CRUD actions for Testcase model.
 */
class TestcaseController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Testcase models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TestcaseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if ($dataProvider->getCount() == 0) {
            $dataProvider = new EmptyDataProvider(new Testcase());
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /**
     * Finds the Testcase model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Testcase the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Testcase::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**
     * post: formName[rowIndex][rowData]
     * @return type
     */
    public function actionSaveRow() {        
        Yii::$app->response->format = Response::FORMAT_JSON;
        $req = Yii::$app->request;     
        if ($req->isAjax) {
            $formName = 'Testcase';
            $className = Testcase::className();
            
            $req = $req->post($formName);
            $rowData = array_values($req)[0];
            $id = $rowData['id'];
            
            if ($rowData['testscenario_id'] > 0) {
                $obj = Testscenario::findOne($rowData['testscenario_id']);
                if ($obj != null) {
                    $rowData['team_id'] = $obj->team_id;
                } else {
                    $rowData['team_id'] = null;
                }
            } else {
                $rowData['team_id'] = null;
            }
            
            $model = $id > 0 ? $className::findOne($id) : null;
            if ($model == null) {//for insert
                $model = new $className();
            }
            //formName in load function must set to empty
            if ($model->load($rowData, '') && $model->save()) {
            }
            return ['result' => $model, 'errors' => $model->errors];
        }
        return [];
    }
    
    public function actionReloadRow() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $req = Yii::$app->request;     
        if ($req->isAjax) {
            $className = Testcase::className();
            
            $id = $req->post('id');
            
            $model = $id > 0 ? $className::findOne($id) : null;
            if ($model == null) {//for insert
                Yii::error("actionReloadRow fail: no record found for id $id");
                return [];
            }
            return ['result' => $model];
        }
        return [];
    }
    
    public function actionDeleteRow()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $req = Yii::$app->request;     
        if ($req->isAjax) {
            
            $id = $req->post('id');
            
            $result = $this->findModel($id)->delete();
            
            if ($result === false) {
                Yii::error("actionDeleteRow fail: $id");
                return ['errors' => true];
            }
            return ['errors' => false];
        }
        return [];
    }
}
