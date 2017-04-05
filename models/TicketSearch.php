<?php

namespace app\modules\teamhelper\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\teamhelper\models\Ticket;

/**
 * TicketSearch represents the model behind the search form about `app\modules\teamhelper\models\Ticket`.
 */
class TicketSearch extends Ticket
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type', 'priority', 'status', 'reporter_id', 'assignee_id', 'phase_id', 'module_id', 'project_id', 'team_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['name', 'code', 'desc', 'start', 'end', 'url'], 'safe'],
            [['estimated'], 'number'],
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
        $query = Ticket::find();

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
            'priority' => $this->priority,
            'status' => $this->status,
            'reporter_id' => $this->reporter_id,
            'assignee_id' => $this->assignee_id,
            'start' => $this->start,
            'end' => $this->end,
            'estimated' => $this->estimated,
            'phase_id' => $this->phase_id,
            'module_id' => $this->module_id,
            'project_id' => $this->project_id,
            'team_id' => $this->team_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'desc', $this->desc])
            ->andFilterWhere(['like', 'url', $this->url]);

        return $dataProvider;
    }
}
