<?php


namespace backend\forms;


use core\entities\User\MultiPrice;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class MultipriceSearch extends Model
{
    public $id;
    public $name;
    public $rate;

    public function rules()
    {
        return [
            [['id', 'rate'], 'integer'],
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
        $query = MultiPrice::find()->with('serviceAssignments');


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