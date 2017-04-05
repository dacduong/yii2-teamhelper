<?php

namespace app\modules\teamhelper\controllers;

use app\modules\teamhelper\models\Ticket;
use app\modules\teamhelper\models\TicketSearch;
use app\modules\teamhelper\rbac\AuthHelper;
use dacduong\inlinegrid\EmptyDataProvider;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * TicketController implements the CRUD actions for Ticket model.
 */
class TicketController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    
                ],                
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Ticket models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TicketSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if ($dataProvider->getCount() == 0) {
            $dataProvider = new EmptyDataProvider(new Ticket());
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Finds the Ticket model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Ticket the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Ticket::findOne($id)) !== null) {
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
            $formName = 'Ticket';
            $className = Ticket::className();
            
            $req = $req->post($formName);
            $rowData = array_values($req)[0];
            $id = $rowData['id'];
            
            if ($rowData['module_id'] > 0) {
                $obj = \app\modules\teamhelper\models\Module::findOne($rowData['module_id']);
                if ($obj != null) {
                    $rowData['team_id'] = $obj->team_id;
                    $rowData['project_id'] = $obj->project_id;
                } else {
                    $rowData['module_id'] = null;
                }
            } else {            
                if ($rowData['project_id'] > 0) {
                    $obj = \app\modules\teamhelper\models\Project::findOne($rowData['project_id']);
                    if ($obj != null) {
                        $rowData['team_id'] = $obj->team_id;
                    } else {
                        $rowData['team_id'] = null;
                        $rowData['project_id'] = null;
                    }
                } else {
                    $rowData['team_id'] = null;
                    $rowData['project_id'] = null;
                }
            }
            
            $model = $id > 0 ? $className::findOne($id) : null;
            if ($model == null) {//for insert
                $model = new $className();
            }
            //formName in load function must set to empty
            if ($model->load($rowData, '') && $model->save()) {
                //create/update new roles
                AuthHelper::createTeamRoles($model->id, $model->name);
            }
            return ['result' => $model, 'errors' => $model->errors];
        }
        return [];
    }
    
    public function actionReloadRow() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $req = Yii::$app->request;     
        if ($req->isAjax) {
            $className = Ticket::className();
            
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
            } else {
                //delete new roles
                AuthHelper::deleteTeamRoles($id);
            }
            return ['errors' => false];
        }
        return [];
    }
}
