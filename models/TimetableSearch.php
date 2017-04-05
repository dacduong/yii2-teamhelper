<?php

namespace app\modules\teamhelper\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\teamhelper\models\Timetable;

/**
 * TimetableSearch represents the model behind the search form about `app\modules\teamhelper\models\Timetable`.
 */
class TimetableSearch extends Timetable
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type', 'user_id', 'ticket_id', 'team_id', 'week', 'status', 'approver', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['day0', 'day1', 'day2', 'day3', 'day4', 'day5', 'day6'], 'number'],
            [['remark'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Timetable::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'type' => $this->type,
            'user_id' => $this->user_id,
            'ticket_id' => $this->ticket_id,
            'team_id' => $this->team_id,
            'week' => $this->week,
            'day0' => $this->day0,
            'day1' => $this->day1,
            'day2' => $this->day2,
            'day3' => $this->day3,
            'day4' => $this->day4,
            'day5' => $this->day5,
            'day6' => $this->day6,
            'status' => $this->status,
            'approver' => $this->approver,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'remark', $this->remark]);

        return $dataProvider;
    }
}
