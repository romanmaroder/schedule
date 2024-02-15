<?php


namespace frontend\forms\Salary;


use schedule\entities\Schedule\Event\Event;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class SalarySearch extends Model
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
        /*$query = Event::find()
            ->joinWith(['services s', 'master m', 'client c'])
            ->select(
                [
                    'DATE(start) as start',
                    'SUM(s.price_new) as sum',

                ]
            );*/
        $query = Event::find()
            ->with(['services', 'master', 'client'])
            ->andWhere(['master_id' => \Yii::$app->user->getId()]);

        $dataProvider = new ActiveDataProvider(
            [
                'query' => $query,
                /*'sort' => [
                    'defaultOrder' => ['id' => SORT_DESC]
                ]*/
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
                'master_id' => \Yii::$app->user->getId(),
            ]
        );


        $query->andFilterWhere(['>=', 'start', $this->start ? $this->start . ' 00:00:00' : null])
            ->andFilterWhere(['<=', 'end', $this->end ? $this->end . ' 23:59:59' : null]);

        $query->groupBy(['DATE(start)']);

        return $dataProvider;
    }

}