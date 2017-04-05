<?php

namespace app\modules\teamhelper\models;

use app\modules\teamhelper\models\base\Testscenario as BaseTestscenario;
use app\modules\teamhelper\rbac\AuthHelper;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

class Testscenario extends BaseTestscenario {

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
                            ['team_id', 'required'],
                            ['team_id', 'validateTeamId'],
                            ['ticket_id', 'validateMatchTeamId'],
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
        if ($this->ticket_id > 0) {
            $team_id = Ticket::findOne(['id' => $this->ticket_id])->team_id;
            if ($this->team_id != $team_id) {
                $errorMsg = 'Team ID for Ticket is not matched!';
                $this->addError('ticket_id', $errorMsg);
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
    
    private $_availableTicket;
    public function getAvailableTicket() {
        if (isset($this->_availableTicket)){
            return $this->_availableTicket;
        }
        $result = [];
        $objectAQ = $this->getTicket();
        if ($objectAQ->exists()) {
            $row = $objectAQ->one();
            $result[$row->id] = $row->name;
        }
        $this->_availableTicket = $result;
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
