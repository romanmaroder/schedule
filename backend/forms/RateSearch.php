<?php


namespace backend\forms;


use schedule\entities\User\Rate;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class RateSearch extends Model
{
    public $id;
    public $name;
    public $rate;

    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['rate'], 'double'],
            [['name'], 'safe']
        ];
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Rate::find();


        $dataProvider = new ActiveDataProvider(
            [
                'query' => $query,
            ]
        );

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(
            [
                'id' => $this->id,
                'name' => $this->name,
                'rate' => $this->rate,
            ]
        );

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['rate' => $this->rate]);
        return $dataProvider;
    }
}