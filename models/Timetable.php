<?php

namespace app\modules\teamhelper\models;

use app\modules\teamhelper\models\base\Timetable as BaseTimetable;
use yii\helpers\ArrayHelper;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

class Timetable extends BaseTimetable {

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
                            [['day0', 'day1', 'day2', 'day3', 'day4', 'day5', 'day6'], 'number', 'min' => 0, 'max' => 24],
                        ]
        );
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(
                        parent::attributeLabels(), [
                        # custom attributeLabels
                            'day0' => 'Mon',
                            'day1' => 'Tue',
                            'day2' => 'Wed',
                            'day3' => 'Thu',
                            'day4' => 'Fri',
                            'day5' => 'Sat',
                            'day6' => 'Sun',
                        ]
        );
    }
    
    //function to support Select2 widget - Ticket selection
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

}
