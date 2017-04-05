<?php

namespace app\modules\teamhelper\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\web\Controller;
use yii\web\Response;
//use yii\web\UnauthorizedHttpException;

class SearchController extends Controller
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
                        'actions' => ['user', 'team', 'team-object'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    
                ],                
            ],
            [
                'class' => ContentNegotiator::className(),
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
        ];
    }
    
    public function actionUser($q) 
    {    
        $rows = [];
        if (empty($q)) {
        } else {
            $rows = (new Query())
                    ->select('id,username as text')
                    ->from('user')
                    ->orWhere(['like','username',$q])
                    ->limit(10)
                    ->all();
        }
        return ['results' => $rows];
    }
    
    public function actionTeam($q) 
    {
        $user_id = Yii::$app->user->id;
        $team_ids = [];      
        $rows = [];
        if (empty($q)) {
        } else {
            $rows = (new Query())
                    ->select('id,name as text')
                    ->from('it_team')
                    ->orWhere(['like','name',$q])
                    ->andFilterWhere(['id' => $team_ids])
                    ->limit(10)
                    ->all();
        }
        return ['results' => $rows];
    }
    
    /**
     * 
     * @param type $q
     * @param type $type: customer, project, phase, task
     * @param type $team_id
     * @return type json
     */
    public function actionTeamObject($q, $type, $team_id = null) 
    {
        //validate data
        if (!in_array($type, ['project', 'phase', 'customer', 'ticket', 'module', 'testscenario', 'testcase', 'teststep', 'testexecute'])) {
            throw new InvalidParamException();
        }
        if ($team_id) {
            if (!is_numeric($team_id)) {
                throw new InvalidParamException();
            }
        } else {
            $user_id = Yii::$app->user->id;
            $team_id = [];
        }                
        
        $results = [];
        $rows = [];
        if (empty($q)) {
        } else {
            $rows = (new Query())
                    ->select("it_$type.id as id,it_$type.name as text, it_$type.code as ocode, team_id, it_team.name as tname")
                    ->from("it_$type")
                    ->innerJoin('it_team', "it_$type.team_id = it_team.id")
                    ->where(['like', "it_$type.name", $q])
                    ->orWhere(['like', "it_$type.code", $q])
                    ->andFilterWhere(['team_id' => $team_id])
                    ->limit(10)
                    ->all();
        }
        foreach ($rows as $row) {
            $results[] = [
                'id' => $row['id'],
                'text' => empty($row['ocode']) ? $row['text'].' ('.$row['tname'].')' : $row['ocode'].' - '.$row['text'].' ('.$row['tname'].')',
                'team_id' => $row['team_id']
            ];
        }
        return ['results' => $results];
    }
}