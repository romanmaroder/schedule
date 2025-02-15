<?php

namespace backend\forms;

use core\helpers\UserHelper;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * UserSearch represents the model behind the search form of `core\entities\user\User`.
 */
class UserSearch extends Model
{
    public $id;
    public $date_from;
    public $date_to;
    public $username;
    public $email;
    public $phone;
    public $status;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['username', 'email','phone'], 'safe'],
            [['date_from','date_to'],'date','format' => 'php:Y-m-d'],
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
        //$query = User::find();
        $query = UserHelper::clientList();


        $dataProvider = new ActiveDataProvider([
                                                   'query' => $query,
                                                   'pagination' => false,
                                               ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'users.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['>=', 'created_at', $this->date_from ? strtotime($this->date_from . ' 00:00:00') : null])
            ->andFilterWhere(['<=', 'created_at', $this->date_to ? strtotime($this->date_to . ' 23:59:59') : null]);

        return $dataProvider;
    }
}
