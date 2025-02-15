<?php


namespace core\readModels\Expenses;


use core\entities\CommonUses\Brand;
use core\entities\Enums\PaymentOptionsEnum;
use core\entities\Expenses\Expenses\Expenses;
use core\entities\Expenses\Category;
use core\entities\Expenses\Expenses\Tag;
use core\helpers\EventMethodsOfPayment;
use yii\data\ActiveDataProvider;
use yii\data\DataProviderInterface;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

class ExpenseReadRepository
{
    public function getAll(): DataProviderInterface
    {
        $query = Expenses::find()->alias('s')->active('s');
        return $this->getProvider($query);
    }

    public function getAllByCategory(Category $category): DataProviderInterface
    {
        $query = Expenses::find()->alias('s')->active('s')->with('category');
        $ids = ArrayHelper::merge([$category->id], $category->getDescendants()->select('id')->column());
        $query->joinWith(['categoryAssignments ca'], false);
        $query->andWhere(['or', ['s.category_id' => $ids], ['ca.category_id' => $ids]]);
        $query->groupBy('s.id');
        return $this->getProvider($query);
    }

    public function getAllByBrand(Brand $brand): DataProviderInterface
    {
        $query = Expenses::find()->alias('s')->active('s');
        $query->andWhere(['s.brand_id' => $brand->id]);
        return $this->getProvider($query);
    }

    public function getSumByDate($date, PaymentOptionsEnum $type = null)
    {
        $query = Expenses::find()->alias('s')->active('s');
        $query= match ($type) {
            PaymentOptionsEnum::STATUS_CASH => $query->cash(),
            PaymentOptionsEnum::STATUS_CARD => $query->card(),
        };
        $query->andFilterWhere(['>=', 'created_at', strtotime($date['from_date'] ?? 0)])
            ->andFilterWhere(['<=', 'created_at', strtotime($date['to_date'] ?? 0)]);
        return $query->sum('value');
    }

    public function getAllByTag(Tag $tag): DataProviderInterface
    {
        $query = Expenses::find()->alias('s')->active('s');
        $query->joinWith(['tagAssignments ta'], false);
        $query->andWhere(['ta.tag_id' => $tag->id]);
        $query->groupBy('s.id');
        return $this->getProvider($query);
    }

    public function find($id): ?Expenses
    {
        return Expenses::find()->active()->andWhere(['id' => $id])->one();
    }

    public function summ()
    {
        return Expenses::find()->active()->sum('value');
    }

    private function getProvider(ActiveQuery $query): ActiveDataProvider
    {
        return new ActiveDataProvider(
            [
                'query' => $query,
                'sort' => [
                    'defaultOrder' => ['id' => SORT_DESC],
                    'attributes' => [
                        'id' => [
                            'asc' => ['s.id' => SORT_ASC],
                            'desc' => ['s.id' => SORT_DESC],
                        ],
                        'name' => [
                            'asc' => ['s.name' => SORT_ASC],
                            'desc' => ['s.name' => SORT_DESC],
                        ],
                        'value' => [
                            'asc' => ['s.value' => SORT_ASC],
                            'desc' => ['s.value' => SORT_DESC],
                        ],
                    ],
                ],
                'pagination' => false
            ]
        );
    }
}