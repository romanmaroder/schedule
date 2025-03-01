<?php


namespace frontend\widgets;


use core\entities\Shop\Product\Category;
use core\readModels\Shop\CategoryReadRepository;
use yii\base\Widget;
use yii\helpers\Html;

class MainNavCategoriesWidget extends Widget
{
    /**
     * CategoriesWidget constructor.
     * @param Category|null $active
     * @param CategoryReadRepository $categories
     * @param array $config
     */
    public function __construct(
        public readonly Category|null $active,
        private readonly CategoryReadRepository $categories,
        array $config = []
    ) {
        parent::__construct($config);
    }

    private function printNode($categories, $depth = 1): void
    {
        if (is_array($categories)) {
            echo Html::beginTag('ul', ['class' => $depth == 1 ? 'cat_menu' : 'sub_menu']);

            foreach ($categories as $category) {
                $active = $this->active && ($this->active->id == $category->id || $this->active->isChildOf($category));

                if ($category->depth == $depth) {
                    echo Html::beginTag('li', ['class' => $category->children ? 'hassubs' : '']);

                    echo Html::a(
                        Html::encode(
                            $category->name
                        ) . ($category->children ? "<i class='fas fa-chevron-right'></i>" : ''),
                        ['/core/catalog/category', 'id' => $category->id], ['class' => $active ? 'active' : '']
                    );

                    if ($category->children) {
                        $this->printNode($category->children, ++$category->depth);
                    }

                    echo Html::endTag('li');
                }
            }
            echo Html::endTag('ul');
        }
    }

    public function run()
    {
        $this->printNode($this->categories->getTreeForMainMenu());
    }

}


