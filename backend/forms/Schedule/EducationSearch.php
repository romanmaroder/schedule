<?php


namespace backend\forms\Schedule;


use schedule\entities\Schedule\Event\Education;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class EducationSearch extends Model
{
    public $id;
    public $teacher_id;
    public $title;
    public $description;
    public $color;
    public $start;
    public $end;
    public $date_from;
    public $date_to;

    public function rules()
    {
        return [
            [['id', 'teacher_id'], 'integer'],
            [['title', 'description', 'color'], 'string'],
            [['title', 'description', 'color'], 'safe'],
            [['start', 'end', 'date_to', 'date_from'], 'safe'],
        ];
    }

    public function search(array $params): ActiveDataProvider
    {
        $query = Education::find()->with(['teacher', 'student']);
        $dataProvider = new ActiveDataProvider(
            [
                'query' => $query,
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
                'teacher_id' => $this->teacher_id,
            ]
        );

        $query->andFilterWhere(['>=', 'start', $this->date_from ? $this->date_from . ' 00:00:00' : null])
            ->andFilterWhere(['<=', 'end', $this->date_to ? $this->date_to . ' 23:59:59' : null]);

        return $dataProvider;
    }
}