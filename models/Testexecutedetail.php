<?php

namespace app\modules\teamhelper\models;

use app\modules\teamhelper\models\base\Testexecutedetail as BaseTestexecutedetail;
use app\modules\teamhelper\rbac\AuthHelper;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

class Testexecutedetail extends BaseTestexecutedetail {

    public function behaviors() {
        return ArrayHelper::merge(
                        parent::behaviors(), [
                    # custom behaviors
                        [
                        'class' => BlameableBehavior::className(),
                    ],
                        [
                        'class' => TimestampBehavior::className(),
                    ],
                        ]
        );
    }

    public function rules() {
        return ArrayHelper::merge(
                        parent::rules(), [
                        # custom validation rules
                            ['team_id', 'validateTeamId'],
                            ['teststep_id', 'validateMatchTeamId'],
                        ]
        );
    }
    
    public function validateTeamId($attribute, $params) {
        if (!AuthHelper::isAdmin()) {
            if (!in_array($this->$attribute, AuthHelper::teamOfUser())) {
                $this->addError($attribute, "Unauthorization: User has no access permission to $attribute: ".$this->$attribute);
            }
        }
    }
    
    public function validateMatchTeamId($attribute, $params) {
        if ($this->teststep_id > 0) {
            $team_id = Teststep::findOne(['id' => $this->teststep_id])->team_id;
            if ($this->team_id != $team_id) {
                $errorMsg = 'Team ID for Teststep is not matched!';
                $this->addError('teststep_id', $errorMsg);
                $this->addError('*', $errorMsg);  
            }
        }
    }

    //function to support Select2 widget - Team selection
    private $_availableTeam;
    public function getAvailableTeam() {
        if (isset($this->_availableTeam)){
            return $this->_availableTeam;
        }
        $result = [];
        $objectAQ = $this->getTeam();
        if ($objectAQ->exists()) {
            $row = $objectAQ->one();
            $result[$row->id] = $row->name;
        }
        $this->_availableTeam = $result;
        return $result;
    }
    
    private $_availableTeststep;
    public function getAvailableTeststep() {
        if (isset($this->_availableTeststep)){
            return $this->_availableTeststep;
        }
        $result = [];
        $objectAQ = $this->getTeststep();
        if ($objectAQ->exists()) {
            $row = $objectAQ->one();
            $result[$row->id] = $row->name;
        }
        $this->_availableTeststep = $result;
        return $result;
    }

}
