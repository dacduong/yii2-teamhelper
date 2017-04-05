<?php

namespace app\modules\teamhelper\models\base;

use Yii;

/**
 * This is the model class for table "it_testscenario".
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property string $desc
 * @property integer $priority
 * @property integer $ticket_id
 * @property integer $module_id
 * @property integer $team_id
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 *
 * @property Testcase[] $testcases
 * @property Testexecute[] $testexecutes
 * @property Module $module
 * @property Team $team
 * @property Ticket $ticket
 */
class Testscenario extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'it_testscenario';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['priority', 'ticket_id', 'module_id', 'team_id'], 'integer'],
            [['name', 'code'], 'string', 'max' => 255],
            [['desc'], 'string', 'max' => 1024],
            [['code'], 'unique'],
            [['module_id'], 'exist', 'skipOnError' => true, 'targetClass' => Module::className(), 'targetAttribute' => ['module_id' => 'id']],
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
            'name' => 'Name',
            'code' => 'Code',
            'desc' => 'Desc',
            'priority' => 'Priority',
            'ticket_id' => 'Ticket ID',
            'module_id' => 'Module ID',
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
    public function getTestcases()
    {
        return $this->hasMany(Testcase::className(), ['testscenario_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTestexecutes()
    {
        return $this->hasMany(Testexecute::className(), ['testscenario_id' => 'id']);
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
