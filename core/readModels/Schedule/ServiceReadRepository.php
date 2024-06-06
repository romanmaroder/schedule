<?php


namespace core\readModels\Schedule;


use core\entities\Schedule\Category;
use core\entities\Schedule\Service\Service;
use core\entities\Schedule\Tag;
use yii\data\ActiveDataProvider;
use yii\data\DataProviderInterface;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

class ServiceReadRepository
{
    public function getAll(): DataProviderInterface
    {
        $query = Service::find()->alias('s')->active('s');
        return $this->getProvider($query);
    }

    public function getAllByCategory(Category $category): DataProviderInterface
    {
        $query = Service::find()->alias('s')->active('s')->with('category');
        $ids = ArrayHelper::merge([$category->id], $category->getDescendants()->select('id')->column());
        $query->joinWith(['categoryAssignments ca'], false);
        $query->andWhere(['or', ['s.category_id' => $ids], ['ca.category_id' => $ids]]);
        $query->groupBy('s.id');
        return $this->getProvider($query);
    }


    public function getAllByBrand(\core\entities\CommonUses\Brand $brand): DataProviderInterface
    {
        $query = Service::find()->alias('s')->active('s');
        $query->andWhere(['s.brand_id' => $brand->id]);
        return $this->getProvider($query);
    }

    public function getAllByTag(Tag $tag): DataProviderInterface
    {
        $query = Service::find()->alias('s')->active('s');
        $query->joinWith(['tagAssignments ta'], false);
        $query->andWhere(['ta.tag_id' => $tag->id]);
        $query->groupBy('s.id');
        return $this->getProvider($query);
    }

    public function find($id): ?Service
    {
        return Service::find()->active()->andWhere(['id' => $id])->one();
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
                        'price' => [
                            'asc' => ['s.price_new' => SORT_ASC],
                            'desc' => ['s.price_new' => SORT_DESC],
                        ],
                        'rating' => [
                            'asc' => ['s.rating' => SORT_ASC],
                            'desc' => ['s.rating' => SORT_DESC],
                        ],
                    ],
                ],
                'pagination' => [
                    'pageSizeLimit' => [15, 100],
                ]
            ]
        );
    }
}