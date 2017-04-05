<?php

namespace app\modules\teamhelper\models\base;

use Yii;

/**
 * This is the model class for table "it_ticket".
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property integer $external_id
 * @property string $desc
 * @property integer $type
 * @property integer $priority
 * @property integer $status
 * @property integer $reporter_id
 * @property string $reporter
 * @property integer $assignee_id
 * @property string $assignee
 * @property string $start
 * @property string $end
 * @property integer $estimated
 * @property integer $phase_id
 * @property integer $module_id
 * @property integer $project_id
 * @property integer $team_id
 * @property string $url
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 *
 * @property Testexecute[] $testexecutes
 * @property Testscenario[] $testscenarios
 * @property Module $module
 * @property Phase $phase
 * @property Project $project
 * @property Team $team
 * @property Timetable[] $timetables
 */
class Ticket extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'it_ticket';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'project_id', 'team_id'], 'required'],
            [['external_id', 'type', 'priority', 'status', 'reporter_id', 'assignee_id', 'estimated', 'phase_id', 'module_id', 'project_id', 'team_id'], 'integer'],
            [['start', 'end'], 'safe'],
            [['name', 'code', 'reporter', 'assignee', 'url'], 'string', 'max' => 255],
            [['desc'], 'string', 'max' => 4096],
            [['code'], 'unique'],
            [['external_id'], 'unique'],
            [['module_id'], 'exist', 'skipOnError' => true, 'targetClass' => Module::className(), 'targetAttribute' => ['module_id' => 'id']],
            [['phase_id'], 'exist', 'skipOnError' => true, 'targetClass' => Phase::className(), 'targetAttribute' => ['phase_id' => 'id']],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project_id' => 'id']],
            [['team_id'], 'exist', 'skipOnError' => true, 'targetClass' => Team::className(), 'targetAttribute' => ['team_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'code' => 'Code',
            'external_id' => 'External ID',
            'desc' => 'Desc',
            'type' => 'Type',
            'priority' => 'Priority',
            'status' => 'Status',
            'reporter_id' => 'Reporter ID',
            'reporter' => 'Reporter',
            'assignee_id' => 'Assignee ID',
            'assignee' => 'Assignee',
            'start' => 'Start',
            'end' => 'End',
            'estimated' => 'Estimated',
            'phase_id' => 'Phase ID',
            'module_id' => 'Module ID',
            'project_id' => 'Project ID',
            'team_id' => 'Team ID',
            'url' => 'Url',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTestexecutes()
    {
        return $this->hasMany(Testexecute::className(), ['ticket_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTestscenarios()
    {
        return $this->hasMany(Testscenario::className(), ['ticket_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModule()
    {
        return $this->hasOne(Module::className(), ['id' => 'module_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPhase()
    {
        return $this->hasOne(Phase::className(), ['id' => 'phase_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'project_id']);
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
    public function getTimetables()
    {
        return $this->hasMany(Timetable::className(), ['ticket_id' => 'id']);
    }
}
