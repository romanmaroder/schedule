<?php


namespace frontend\widgets\Blog;


use core\entities\Blog\Category;
use core\readModels\Blog\CategoryReadRepository;
use core\readModels\Blog\PostReadRepository;
use Yii;
use yii\base\Widget;
use yii\helpers\Html;

class CategoriesWidget extends Widget
{
    public function __construct(
        public Category|null $active,
        private readonly CategoryReadRepository $categories,
        private readonly PostReadRepository $posts,
        $config = []
    ) {
        parent::__construct($config);
    }

    public function run(): void
    {
        $post = $this->posts->count();
        /*return Html::tag(
            'ul',
            implode(
                PHP_EOL,
                array_map(
                    function (Category $category) {
                        $active = $this->active && ($this->active->id == $category->id);
                        return Html::tag('li', Html::a(Html::encode($category->name),['/blog/post/category', 'slug' => $category->slug],
                                                       ['class' => $active ? 'nav-link active' : 'nav-link']),[
                                                           'class'=>'nav-item'
                        ]);
                    },
                    $this->categories->getAll()
                )
            ),
            [
                'class' => 'nav flex-column sticky-top',
            ]
        );*/

        if ($post > 0) {
            $this->categoryList();
        }
    }

    private function categoryList(): void
    {
        $count = 0;
        echo Html::beginTag('div', ['class' => 'section-title']);
        echo Html::beginTag('h2');
        echo Yii::t('blog', 'Popular Posts');
        echo Html::endTag('h2');
        echo Html::endTag('div');
        foreach ($this->categories->getAll() as $category) {
            $active = $this->active && ($this->active->id == $category->id);
            $count++;
            echo Html::beginTag('div', ['class' => 'trend-entry d-flex']);
            echo Html::tag('div', $count, ['class' => 'number align-self-start']);
            echo Html::beginTag('div', ['class' => 'trend-contents']);
            echo Html::beginTag('h2');
            echo Html::a(
                Html::encode($category->name),
                ['/blog/post/category', 'slug' => $category->slug],
                ['class' => $active ? 'active' : '']
            );
            echo Html::endTag('h2');
            echo Html::beginTag('div', ['class' => 'post-meta']);
            echo Html::tag(
                'span',
                Html::encode($category->meta->description),
                ['class' => $active ? 'd-block active' : 'd-block']
            );
            echo Html::endTag('div');
            echo Html::endTag('div');
            echo Html::endTag('div');
        }
        echo Html::beginTag('p');
        echo Html::a(
            \Yii::t('app', 'See All Popular') . '<i class="fas fa-angle-right"></i>',
            ['/blog/post/index'],
            ['class' => 'more']
        );
        echo Html::endTag('p');
    }
}