<?php

namespace app\modules\teamhelper\models;

use app\modules\teamhelper\models\base\Teststep as BaseTeststep;
use app\modules\teamhelper\rbac\AuthHelper;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

class Teststep extends BaseTeststep {

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
                            ['testcase_id', 'validateMatchTeamId'],
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
        if ($this->testcase_id > 0) {
            $team_id = Testcase::findOne(['id' => $this->testcase_id])->team_id;
            if ($this->team_id != $team_id) {
                $errorMsg = 'Team ID for Testcase is not matched!';
                $this->addError('testcase_id', $errorMsg);
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
    
    private $_availableTestcase;
    public function getAvailableTestcase() {
        if (isset($this->_availableTestcase)){
            return $this->_availableTestcase;
        }
        $result = [];
        $objectAQ = $this->getTestcase();
        if ($objectAQ->exists()) {
            $row = $objectAQ->one();
            $result[$row->id] = $row->name;
        }
        $this->_availableTestcase = $result;
        return $result;
    }

}
