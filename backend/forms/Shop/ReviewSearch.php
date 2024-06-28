<?php


namespace backend\forms\Shop;


use core\entities\Shop\Product\Review;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class ReviewSearch extends Model
{
    public $id;
    public $vote;
    public $text;
    public $product_id;
    public $user_id;
    public $user;
    public $product;

    public function rules(): array
    {
        return [
            [['id', 'product_id', 'user_id','vote'], 'integer'],
            [['text'], 'safe'],
        ];
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Review::find()->with(['user','product']);

        $dataProvider = new ActiveDataProvider(
            [
                'query' => $query,
                'key' => function (Review $review) {
                    return [
                        'product_id' => $review->product_id,
                        'id' => $review->id,
                    ];
                },
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
                'user_id' => $this->user_id,
                'product_id' => $this->product_id,
            ]
        );

        $query
            ->andFilterWhere(['like', 'text', $this->text]);

        return $dataProvider;
    }

}