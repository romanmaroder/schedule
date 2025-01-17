<?php


namespace backend\forms\Schedule;


use core\entities\Schedule\Event\Event;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class EventSearch extends Model
{

    public $id;
    public $client_id;
    public $master_id;
    public $notice;
    public $start;
    public $end;
    public $amount;

    public function rules(): array
    {
        return [
            [['id', 'client_id', 'master_id', 'amount'], 'integer'],
            [['notice'], 'string'],
            [['notice'], 'safe'],
            [['start', 'end'], 'safe'],
        ];
    }

    public function search(array $params): ?ActiveDataProvider
    {
        $query = Event::find()->with('services', 'employee', 'master', 'client');


        $dataProvider = new ActiveDataProvider(
            [
                'query' => $query,
                'pagination' => false,
                'sort' => [
                    'start' => ['start' => SORT_ASC],
                ]
            ]
        );
        $this->load($params);

        if ($params['from_date'] == null || $params['to_date'] == null) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(
            [
                'id' => $this->id,
                'master_id' => \Yii::$app->id == 'app-backend' ? $this->master_id : \Yii::$app->user->getId(),
                'client_id' => $this->client_id,
                'amount' => $this->amount,
            ]
        );
        $query->andFilterWhere(['between', 'DATE(start)', $params['from_date'], $params['to_date']]);
        return $dataProvider;
    }

}