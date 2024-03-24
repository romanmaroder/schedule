<?php


namespace frontend\widgets;


use schedule\entities\Schedule\Category;
use schedule\readModels\Schedule\CategoryReadRepository;
use yii\base\Widget;
use yii\helpers\Html;

class MainNavCategoriesWidget extends Widget
{
    /** @var Category|null */
    public $active;
    private $categories;


    /**
     * CategoriesWidget constructor.
     * @param CategoryReadRepository $categories
     * @param array $config
     */
    public function __construct(CategoryReadRepository $categories, $config = [])
    {
        parent::__construct($config);
        $this->categories = $categories;

    }

    private function printNode($categories, $depth = 1)
    {
        if (is_array($categories)) {
            echo Html::beginTag('ul', ['class' => $depth == 1 ? 'cat_menu' : 'sub_menu']);

            foreach ($categories as $category) {
                $active = $this->active && ($this->active->id == $category->id || $this->active->isChildOf($category));

                if ($category->depth == $depth) {

                    echo Html::beginTag('li', ['class' => $category->children ? 'hassubs' : '']);

                    echo Html::a(Html::encode($category->name) . ($category->children ? "<i class='fas fa-chevron-right'></i>" : ''),
                        ['/schedule/catalog/category', 'id' => $category->id],['class' => $active ? 'active' : '']
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


