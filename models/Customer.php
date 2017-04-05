<?php

namespace app\modules\teamhelper\models;

use app\modules\teamhelper\models\base\Customer as BaseCustomer;
use app\modules\teamhelper\rbac\AuthHelper;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

class Customer extends BaseCustomer {

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

}
