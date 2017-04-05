<?php

namespace app\modules\teamhelper\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\teamhelper\models\Teststep;

/**
 * TeststepSearch represents the model behind the search form about `app\modules\teamhelper\models\Teststep`.
 */
class TeststepSearch extends Teststep
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'sequence', 'testcase_id', 'team_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['name', 'desc'], 'safe'],
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
        $query = Teststep::find();

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
            'sequence' => $this->sequence,
            'testcase_id' => $this->testcase_id,
            'team_id' => $this->team_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'desc', $this->desc]);

        return $dataProvider;
    }
}
