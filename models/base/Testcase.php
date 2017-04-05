<?php

namespace app\modules\teamhelper\models\base;

use Yii;

/**
 * This is the model class for table "it_testcase".
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property string $desc
 * @property string $precondition
 * @property string $postcondition
 * @property string $dependencies
 * @property integer $testscenario_id
 * @property integer $team_id
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 *
 * @property Team $team
 * @property Testscenario $testscenario
 * @property Testexecute[] $testexecutes
 * @property Teststep[] $teststeps
 */
class Testcase extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'it_testcase';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'testscenario_id'], 'required'],
            [['testscenario_id', 'team_id'], 'integer'],
            [['name', 'code'], 'string', 'max' => 255],
            [['desc'], 'string', 'max' => 1025],
            [['precondition', 'postcondition', 'dependencies'], 'string', 'max' => 1024],
            [['code'], 'unique'],
            [['team_id'], 'exist', 'skipOnError' => true, 'targetClass' => Team::className(), 'targetAttribute' => ['team_id' => 'id']],
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
            'name' => 'Name',
            'code' => 'Code',
            'desc' => 'Desc',
            'precondition' => 'Precondition',
            'postcondition' => 'Postcondition',
            'dependencies' => 'Dependencies',
            'testscenario_id' => 'Testscenario ID',
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
    public function getTeam()
    {
        return $this->hasOne(Team::className(), ['id' => 'team_id']);
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
    public function getTestexecutes()
    {
        return $this->hasMany(Testexecute::className(), ['testcase_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeststeps()
    {
        return $this->hasMany(Teststep::className(), ['testcase_id' => 'id']);
    }
}
