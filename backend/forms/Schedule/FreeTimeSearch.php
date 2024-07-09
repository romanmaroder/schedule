<?php


namespace backend\forms\Schedule;


use core\entities\Schedule\Event\FreeTime;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class FreeTimeSearch extends Model
{

    public $id;
    public $additional_id;
    public $master_id;
    public $start;
    public $end;
    public $notice;

    public function rules(): array
    {
        return [
            [['id', 'additional_id', 'master_id'], 'integer'],
            [['notice'], 'string'],
            [['notice'], 'safe'],
            [['start', 'end'], 'safe'],
        ];
    }

    public function search(array $params): ActiveDataProvider
    {
         $query = FreeTime::find()->joinWith(['additional','master']);

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
                'additional_id' => $this->additional_id,
            ]
        );


        $query->andFilterWhere(['>=', 'start', $this->start ? $this->start . ' 00:00:00' : null])
            ->andFilterWhere(['<=', 'end', $this->end ? $this->end . ' 23:59:59' : null]);


        return $dataProvider;
    }

}