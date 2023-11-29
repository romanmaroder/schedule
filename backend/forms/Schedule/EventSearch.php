<?php


namespace backend\forms\Schedule;


use schedule\entities\Schedule\Event\Event;
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
    public $date_from;
    public $date_to;

    public function rules(): array
    {
        return [
            [['id', 'client_id', 'master_id'], 'integer'],
            [['notice'], 'string'],
            [['notice'], 'safe'],
            [['start', 'end', 'date_to', 'date_from'], 'safe'],
        ];
    }

    public function search(array $params): ActiveDataProvider
    {
        $query = Event::find()->with(['services','master','client']);

        $dataProvider = new ActiveDataProvider(
            [
            'query'=>$query,
                'sort' => [
                    'defaultOrder'=>['id'=>SORT_DESC]
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
                'master_id' => $this->master_id,
                'client_id' => $this->client_id,
            ]
        );

        $query->andFilterWhere(['>=', 'start', $this->date_from ? $this->date_from . ' 00:00:00' : null])
            ->andFilterWhere(['<=', 'end', $this->date_to ? $this->date_to . ' 23:59:59' : null]);

        return $dataProvider;

    }

}