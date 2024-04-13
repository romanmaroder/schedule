<?php


namespace schedule\readModels\Employee;


use schedule\entities\User\Employee\Employee;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

class EmployeeReadRepository
{
    public function find($id): ?Employee
    {
        return Employee::find()->with('role')->andWhere(['id' => $id])->one();
    }

    public function findEmployee($id)
    {
        return Employee::find()->with('role')->andWhere(['user_id' => $id])->one();
    }

    private function getProvider(ActiveQuery $query): ActiveDataProvider
    {
        return new ActiveDataProvider(
            [
                'query' => $query,
                /*'sort' => [
                    'defaultOrder' => ['id' => SORT_DESC],
                    'attributes' => [
                        'id' => [
                            'asc' => ['p.id' => SORT_ASC],
                            'desc' => ['p.id' => SORT_DESC],
                        ],
                        'name' => [
                            'asc' => ['p.name' => SORT_ASC],
                            'desc' => ['p.name' => SORT_DESC],
                        ],
                        'price' => [
                            'asc' => ['p.price_new' => SORT_ASC],
                            'desc' => ['p.price_new' => SORT_DESC],
                        ],
                        'rating' => [
                            'asc' => ['p.rating' => SORT_ASC],
                            'desc' => ['p.rating' => SORT_DESC],
                        ],
                    ],
                ],
                'pagination' => [
                    'pageSizeLimit' => [15, 100],
                ]*/
            ]
        );
    }
}