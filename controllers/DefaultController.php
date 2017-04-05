<?php

namespace app\modules\teamhelper\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Default controller for the `teamhelper` module
 */
class DefaultController extends Controller
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
        ];
    }
    
    public function actionIndex()
    {
        $this->redirect('teamhelper/timetable/index', 302);
        //return $this->render('index');
    }
}
