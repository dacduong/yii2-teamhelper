<?php

namespace app\modules\teamhelper\models\base;

use Yii;

/**
 * This is the model class for table "it_timetable".
 *
 * @property integer $id
 * @property integer $type
 * @property integer $user_id
 * @property integer $ticket_id
 * @property integer $team_id
 * @property integer $week
 * @property string $day0
 * @property string $day1
 * @property string $day2
 * @property string $day3
 * @property string $day4
 * @property string $day5
 * @property string $day6
 * @property string $remark
 * @property integer $status
 * @property integer $approver
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 *
 * @property Team $team
 * @property Ticket $ticket
 */
class Timetable extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'it_timetable';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'user_id', 'ticket_id', 'team_id', 'week', 'status', 'approver'], 'integer'],
            [['user_id', 'week'], 'required'],
            [['day0', 'day1', 'day2', 'day3', 'day4', 'day5', 'day6'], 'number'],
            [['remark'], 'string', 'max' => 255],
            [['team_id'], 'exist', 'skipOnError' => true, 'targetClass' => Team::className(), 'targetAttribute' => ['team_id' => 'id']],
            [['ticket_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ticket::className(), 'targetAttribute' => ['ticket_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'user_id' => 'User ID',
            'ticket_id' => 'Ticket ID',
            'team_id' => 'Team ID',
            'week' => 'Week',
            'day0' => 'Day0',
            'day1' => 'Day1',
            'day2' => 'Day2',
            'day3' => 'Day3',
            'day4' => 'Day4',
            'day5' => 'Day5',
            'day6' => 'Day6',
            'remark' => 'Remark',
            'status' => 'Status',
            'approver' => 'Approver',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeam()
    {
        return $this->hasOne(Team::className(), ['id' => 'team_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTicket()
    {
        return $this->hasOne(Ticket::className(), ['id' => 'ticket_id']);
    }
}
