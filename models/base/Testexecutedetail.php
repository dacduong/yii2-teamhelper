<?php

namespace app\modules\teamhelper\models\base;

use Yii;

/**
 * This is the model class for table "it_testexecutedetail".
 *
 * @property integer $id
 * @property integer $teststep_id
 * @property string $testdata
 * @property string $expectedresult
 * @property string $postcondition
 * @property string $actualresult
 * @property integer $status
 * @property string $notes
 * @property integer $testexecute_id
 * @property integer $team_id
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 *
 * @property Testexecute $testexecute
 * @property Team $team
 * @property Teststep $teststep
 */
class Testexecutedetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'it_testexecutedetail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['teststep_id', 'status', 'testexecute_id', 'team_id'], 'integer'],
            [['testdata', 'expectedresult', 'postcondition', 'actualresult', 'notes'], 'string', 'max' => 2048],
            [['testexecute_id'], 'exist', 'skipOnError' => true, 'targetClass' => Testexecute::className(), 'targetAttribute' => ['testexecute_id' => 'id']],
            [['team_id'], 'exist', 'skipOnError' => true, 'targetClass' => Team::className(), 'targetAttribute' => ['team_id' => 'id']],
            [['teststep_id'], 'exist', 'skipOnError' => true, 'targetClass' => Teststep::className(), 'targetAttribute' => ['teststep_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'teststep_id' => 'Teststep ID',
            'testdata' => 'Testdata',
            'expectedresult' => 'Expectedresult',
            'postcondition' => 'Postcondition',
            'actualresult' => 'Actualresult',
            'status' => 'Status',
            'notes' => 'Notes',
            'testexecute_id' => 'Testexecute ID',
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
    public function getTestexecute()
    {
        return $this->hasOne(Testexecute::className(), ['id' => 'testexecute_id']);
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
    public function getTeststep()
    {
        return $this->hasOne(Teststep::className(), ['id' => 'teststep_id']);
    }
}
