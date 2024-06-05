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

    public function rules(): array
    {
        return [
            [['id', 'client_id', 'master_id'], 'integer'],
            [['notice'], 'string'],
            [['notice'], 'safe'],
            [['start', 'end'], 'safe'],
        ];
    }

    public function search(array $params): ActiveDataProvider
    {
         $query = Event::find()->joinWith(['services','master','client']);

        $dataProvider = new ActiveDataProvider(
            [
                'query' => $query,
                'pagination' => false,
                'sort' => [
                    'defaultOrder' => ['id' => SORT_DESC]
                ]
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
                'master_id' => \Yii::$app->id == 'app-backend' ? $this->master_id : \Yii::$app->user->getId(),
                'client_id' => $this->client_id,
            ]
        );


        $query->andFilterWhere(['>=', 'start', $this->start ? $this->start . ' 00:00:00' : null])
            ->andFilterWhere(['<=', 'end', $this->end ? $this->end . ' 23:59:59' : null]);


        return $dataProvider;
    }

}