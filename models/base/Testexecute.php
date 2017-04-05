<?php

namespace app\modules\teamhelper\models\base;

use Yii;

/**
 * This is the model class for table "it_testexecute".
 *
 * @property integer $id
 * @property integer $testcase_id
 * @property string $targetmodule
 * @property string $targetversion
 * @property integer $status
 * @property string $summary
 * @property integer $testscenario_id
 * @property integer $ticket_id
 * @property integer $team_id
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 *
 * @property Testcase $testcase
 * @property Team $team
 * @property Ticket $ticket
 * @property Testscenario $testscenario
 * @property Testexecutedetail[] $testexecutedetails
 */
class Testexecute extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'it_testexecute';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['testcase_id', 'status', 'testscenario_id', 'ticket_id', 'team_id'], 'integer'],
            [['targetmodule'], 'string', 'max' => 255],
            [['targetversion'], 'string', 'max' => 20],
            [['summary'], 'string', 'max' => 2048],
            [['testcase_id'], 'exist', 'skipOnError' => true, 'targetClass' => Testcase::className(), 'targetAttribute' => ['testcase_id' => 'id']],
            [['team_id'], 'exist', 'skipOnError' => true, 'targetClass' => Team::className(), 'targetAttribute' => ['team_id' => 'id']],
            [['ticket_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ticket::className(), 'targetAttribute' => ['ticket_id' => 'id']],
            [['testscenario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Testscenario::className(), 'targetAttribute' => ['testscenario_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'testcase_id' => 'Testcase ID',
            'targetmodule' => 'Targetmodule',
            'targetversion' => 'Targetversion',
            'status' => 'Status',
            'summary' => 'Summary',
            'testscenario_id' => 'Testscenario ID',
            'ticket_id' => 'Ticket ID',
            'team_id' => 'Team ID',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTestcase()
    {
        return $this->hasOne(Testcase::className(), ['id' => 'testcase_id']);
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTestscenario()
    {
        return $this->hasOne(Testscenario::className(), ['id' => 'testscenario_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTestexecutedetails()
    {
        return $this->hasMany(Testexecutedetail::className(), ['testexecute_id' => 'id']);
    }
}
