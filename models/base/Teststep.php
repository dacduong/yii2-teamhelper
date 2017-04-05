<?php

namespace app\modules\teamhelper\models\base;

use Yii;

/**
 * This is the model class for table "it_teststep".
 *
 * @property integer $id
 * @property string $name
 * @property string $desc
 * @property integer $sequence
 * @property integer $testcase_id
 * @property integer $team_id
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 *
 * @property Testexecutedetail[] $testexecutedetails
 * @property Testcase $testcase
 * @property Team $team
 */
class Teststep extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'it_teststep';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['sequence', 'testcase_id', 'team_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['desc'], 'string', 'max' => 1024],
            [['sequence', 'testcase_id'], 'unique', 'targetAttribute' => ['sequence', 'testcase_id'], 'message' => 'The combination of Sequence and Testcase ID has already been taken.'],
            [['testcase_id'], 'exist', 'skipOnError' => true, 'targetClass' => Testcase::className(), 'targetAttribute' => ['testcase_id' => 'id']],
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
            'desc' => 'Desc',
            'sequence' => 'Sequence',
            'testcase_id' => 'Testcase ID',
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
    public function getTestexecutedetails()
    {
        return $this->hasMany(Testexecutedetail::className(), ['teststep_id' => 'id']);
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
}
