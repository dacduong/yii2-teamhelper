<?php

namespace app\modules\teamhelper\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\teamhelper\models\Testexecutedetail;

/**
 * TestexecutedetailSearch represents the model behind the search form about `app\modules\teamhelper\models\Testexecutedetail`.
 */
class TestexecutedetailSearch extends Testexecutedetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'teststep_id', 'status', 'testexecute_id', 'team_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['testdata', 'expectedresult', 'postcondition', 'actualresult', 'notes'], 'safe'],
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
        $query = Testexecutedetail::find();

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
            'teststep_id' => $this->teststep_id,
            'status' => $this->status,
            'testexecute_id' => $this->testexecute_id,
            'team_id' => $this->team_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'testdata', $this->testdata])
            ->andFilterWhere(['like', 'expectedresult', $this->expectedresult])
            ->andFilterWhere(['like', 'postcondition', $this->postcondition])
            ->andFilterWhere(['like', 'actualresult', $this->actualresult])
            ->andFilterWhere(['like', 'notes', $this->notes]);

        return $dataProvider;
    }
}
