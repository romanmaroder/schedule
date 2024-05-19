<?php

namespace backend\forms;

use schedule\entities\User\Employee\Employee;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

/**
 * UserSearch represents the model behind the search form of `schedule\entities\user\User`.
 */
class EmployeeSearch extends Model
{
    public $id;
    public $first_name;
    public $last_name;
    public $username;
    public $role;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['first_name', 'last_name','username'], 'string'],
            [['role'], 'safe']
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
        $query = Employee::find()->alias('e')->joinWith(['user']);


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
                'e.id' => $this->id,
                'e.first_name' => $this->first_name,
                'e.last_name' => $this->last_name,
                'users.username' => $this->username,
            ]
        );

        if (!empty($this->role)) {
            $query->innerJoin('{{%auth_assignments}} a', 'a.user_id = users.id');
            $query->andWhere(['a.item_name' => $this->role]);
        }

        $query->andFilterWhere(['like', 'e.first_name', $this->first_name])
            ->andFilterWhere(['like', 'e.last_name', $this->last_name]);

        return $dataProvider;
    }
    public function rolesList(): array
    {
        return ArrayHelper::map(\Yii::$app->authManager->getRoles(), 'name', 'description');
    }
}
