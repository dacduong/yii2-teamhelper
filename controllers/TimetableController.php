<?php

namespace app\modules\teamhelper\controllers;

use app\modules\teamhelper\helpers\Constants;
use app\modules\teamhelper\models\Ticket;
use app\modules\teamhelper\models\Timetable;
use app\modules\teamhelper\models\TimetableSearch;
use app\modules\teamhelper\rbac\AuthHelper;
use dacduong\inlinegrid\EmptyDataProvider;
use DateTime;
use InvalidArgumentException;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UnauthorizedHttpException;

/**
 * TimetableController implements the CRUD actions for Timetable model.
 */
class TimetableController extends Controller
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
     * Lists all Timetable models.
     * @return mixed
     */
    public function actionIndex($week = '', $id = null)
    {
        try {
            if ($id) {
                if (Yii::$app->user->id != $id) {
                    if (!AuthHelper::isAdmin()) {
                        throw new UnauthorizedHttpException();
                    }
                }
            } else {
                $id = Yii::$app->user->id;
            }
            $date = new DateTime();
            $dateStr = $date->format(Constants::DATE_FORMAT);
            if (!empty($week)) {
                $dateStr = $week;
                $date = DateTime::createFromFormat(Constants::DATE_FORMAT, $dateStr);                
            }
            $dayOfWeek = $date->format('N');//1 Monday, 7: Sunday            
            $fromStr = date(Constants::DATE_DISPLAY_FORMAT, strtotime($dateStr.' -'.($dayOfWeek - 1).' day'));
            $fromDate = date(Constants::DATE_FORMAT, strtotime($dateStr.' -'.($dayOfWeek - 1).' day'));
            $previousDate = date(Constants::DATE_FORMAT, strtotime($dateStr.' -'.$dayOfWeek.' day'));
            $toStr = date(Constants::DATE_DISPLAY_FORMAT, strtotime($dateStr.' +'.(7 - $dayOfWeek).' day'));
            $nextDate = date(Constants::DATE_FORMAT, strtotime($dateStr.' +'.(8 - $dayOfWeek).' day'));
            Yii::trace("dayOfWeek $dayOfWeek - From $fromStr - To $toStr");
         
            $searchModel = new TimetableSearch();
            $params = Yii::$app->request->queryParams;
            $params['TimetableSearch']['week'] = $fromDate;
            $params['TimetableSearch']['user_id'] = $id;
            $dataProvider = $searchModel->search($params);

            if ($dataProvider->getCount() == 0) {
                $dataProvider = new EmptyDataProvider(new Timetable());
            }
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'fromStr' => $fromStr,
                'toStr' => $toStr,
                'fromDate' => $fromDate,
                'previousDate' => $previousDate,
                'nextDate' => $nextDate,
            ]);
        } catch (Exception $ex) {
            throw new InvalidArgumentException();
        }        
    }

    /**
     * Finds the Timetable model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Timetable the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Timetable::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**
     * post: formName[rowIndex][rowData]
     * @return type
     */
    public function actionSaveRow($week = '') {        
        Yii::$app->response->format = Response::FORMAT_JSON;
        $req = Yii::$app->request;
        if ($req->isAjax) {
            $formName = 'Timetable';
            $className = Timetable::className();
            
            $req = $req->post($formName);
            $rowData = array_values($req)[0];
            $id = $rowData['id'];
            
            $rowData['user_id'] = \Yii::$app->user->id;
            
            if ($rowData['ticket_id'] > 0) {
                $obj = Ticket::findOne($rowData['ticket_id']);
                if ($obj != null) {
                    $rowData['team_id'] = $obj->team_id;
                } else {
                    $rowData['team_id'] = null;
                }
            } else {
                $rowData['team_id'] = null;
            }
            
            //calculate week
            try {
                $date = new DateTime();
                $dateStr = $date->format(Constants::DATE_FORMAT);
                if (!empty($week)) {
                    $dateStr = $week;
                    $date = DateTime::createFromFormat(Constants::DATE_FORMAT, $dateStr);
                }
                $dayOfWeek = $date->format('N');                
                $fromDate = date(Constants::DATE_FORMAT, strtotime($dateStr . ' -' . ($dayOfWeek - 1) . ' day'));
                $rowData['week'] = intval($fromDate);
            } catch (Exception $ex) {
                throw new InvalidArgumentException();
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
            $className = Timetable::className();
            
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
