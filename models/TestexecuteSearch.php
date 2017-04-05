<?php

namespace app\modules\teamhelper\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\teamhelper\models\Testexecute;

/**
 * TestexecuteSearch represents the model behind the search form about `app\modules\teamhelper\models\Testexecute`.
 */
class TestexecuteSearch extends Testexecute
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'testcase_id', 'status', 'testscenario_id', 'ticket_id', 'team_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['targetmodule', 'targetversion', 'summary'], 'safe'],
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
        $query = Testexecute::find();

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
            'testcase_id' => $this->testcase_id,
            'status' => $this->status,
            'testscenario_id' => $this->testscenario_id,
            'ticket_id' => $this->ticket_id,
            'team_id' => $this->team_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'targetmodule', $this->targetmodule])
            ->andFilterWhere(['like', 'targetversion', $this->targetversion])
            ->andFilterWhere(['like', 'summary', $this->summary]);

        return $dataProvider;
    }
}
