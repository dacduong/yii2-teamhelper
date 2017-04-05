<?php

namespace app\modules\teamhelper\models;

use app\modules\teamhelper\models\base\Ticket as BaseTicket;
use app\modules\teamhelper\rbac\AuthHelper;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

class Ticket extends BaseTicket {

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
                            ['phase_id', 'validateMatchTeamId'],
                        ]
        );
    }
    
    public function validateMatchTeamId($attribute, $params) {
        if ($this->project_id > 0) {
            $team_id = Project::findOne(['id' => $this->project_id])->team_id;
            $this->team_id = $team_id;
            if ($this->phase_id) {
                $team_id2 = Phase::findOne(['id' => $this->phase_id])->team_id;
                if ($team_id != $team_id2) {
                    $this->addError('phase_id', 'Team ID for Project & Phase are different!');
                    $this->addError('*', 'Team ID for Project & Phase are different!');
                }
            }
        }
    }
    
    public function validateTeamId($attribute, $params) {
        if (!AuthHelper::isAdmin()) {
            if (!in_array($this->$attribute, AuthHelper::teamOfUser())) {
                $this->addError($attribute, "Unauthorization: User has no access permission to $attribute: ".$this->$attribute);
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
    
    private $_availableProject;
    public function getAvailableProject() {
        if (isset($this->_availableProject)){
            return $this->_availableProject;
        }
        $result = [];
        $objectAQ = $this->getProject();
        if ($objectAQ->exists()) {
            $row = $objectAQ->one();
            $result[$row->id] = $row->name;
        }
        $this->_availableProject = $result;
        return $result;
    }
    
    private $_availablePhase;
    public function getAvailablePhase() {
        if (isset($this->_availablePhase)){
            return $this->_availablePhase;
        }
        $result = [];
        $objectAQ = $this->getPhase();
        if ($objectAQ->exists()) {
            $row = $objectAQ->one();
            $result[$row->id] = $row->name;
        }
        $this->_availablePhase = $result;
        return $result;
    }
    
    private $_availableModule;
    public function getAvailableModule() {
        if (isset($this->_availableModule)){
            return $this->_availableModule;
        }
        $result = [];
        $objectAQ = $this->getModule();
        if ($objectAQ->exists()) {
            $row = $objectAQ->one();
            $result[$row->id] = $row->name;
        }
        $this->_availableModule = $result;
        return $result;
    }

}
