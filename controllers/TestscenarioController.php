<?php

namespace app\modules\teamhelper\controllers;

use app\modules\teamhelper\models\Module;
use app\modules\teamhelper\models\Testscenario;
use app\modules\teamhelper\models\TestscenarioSearch;
use app\modules\teamhelper\models\Ticket;
use dacduong\inlinegrid\EmptyDataProvider;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * TestscenarioController implements the CRUD actions for Testscenario model.
 */
class TestscenarioController extends Controller
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
     * Lists all Testscenario models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TestscenarioSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if ($dataProvider->getCount() == 0) {
            $dataProvider = new EmptyDataProvider(new Testscenario());
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Finds the Testscenario model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Testscenario the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Testscenario::findOne($id)) !== null) {
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
            $formName = 'Testscenario';
            $className = Testscenario::className();
            
            $req = $req->post($formName);
            $rowData = array_values($req)[0];
            $id = $rowData['id'];
            
            if ($rowData['ticket_id'] > 0) {
                $obj = Ticket::findOne($rowData['ticket_id']);
                if ($obj != null) {
                    $rowData['team_id'] = $obj->team_id;
                } else {
                    $rowData['team_id'] = null;
                }
            } else {
                if ($rowData['module_id'] > 0) {
                    $obj = Module::findOne($rowData['module_id']);
                    if ($obj != null) {
                        $rowData['team_id'] = $obj->team_id;
                    } else {
                        $rowData['team_id'] = null;
                    }
                } else {
                    $rowData['team_id'] = null;
                }
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
            $className = Testscenario::className();
            
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
