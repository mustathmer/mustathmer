<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Node;

/**
 * NodeSearchAPI represents the model behind the search form about `common\models\Node`.
 */
class NodeSearchAPI extends Node
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'country_id', 'city_id', 'start_point_city_id', 'end_point_city_id'], 'integer'],
            [['name', 'mobile', 'start_point_area', 'start_point_time', 'end_point_area', 'end_point_time', 'available', 'description', 'created_at', 'updated_at'], 'safe'],
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
        $query = Node::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, '');

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'country_id' => $this->country_id,
            'city_id' => $this->city_id,
            'start_point_city_id' => $this->start_point_city_id,
            'start_point_time' => $this->start_point_time,
            'end_point_city_id' => $this->end_point_city_id,
            'end_point_time' => $this->end_point_time,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'mobile', $this->mobile])
            ->andFilterWhere(['like', 'start_point_area', $this->start_point_area])
            ->andFilterWhere(['like', 'end_point_area', $this->end_point_area])
            ->andFilterWhere(['like', 'available', $this->available])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
