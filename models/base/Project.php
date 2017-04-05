<?php

namespace app\modules\teamhelper\models\base;

use Yii;

/**
 * This is the model class for table "it_project".
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property string $desc
 * @property integer $status
 * @property integer $team_id
 * @property integer $customer_id
 * @property integer $external_id
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 *
 * @property Module[] $modules
 * @property Customer $customer
 * @property Team $team
 * @property Ticket[] $tickets
 */
class Project extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'it_project';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['status', 'team_id', 'customer_id', 'external_id'], 'integer'],
            [['name', 'code'], 'string', 'max' => 255],
            [['desc'], 'string', 'max' => 2048],
            [['code'], 'unique'],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['customer_id' => 'id']],
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
            'desc' => 'Desc',
            'status' => 'Status',
            'team_id' => 'Team ID',
            'customer_id' => 'Customer ID',
            'external_id' => 'External ID',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModules()
    {
        return $this->hasMany(Module::className(), ['project_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
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
    public function getTickets()
    {
        return $this->hasMany(Ticket::className(), ['project_id' => 'id']);
    }
}
