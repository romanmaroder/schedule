<?php


namespace backend\forms;


use core\entities\User\Role;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class RoleSearch extends Model
{
    public $id;
    public $name;

    public function rules()
    {
        return [
            [['id'], 'integer'],
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
        $query = Role::find();


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
            ]
        );

        $query->andFilterWhere(['like', 'name', $this->name]);
        return $dataProvider;
    }
}