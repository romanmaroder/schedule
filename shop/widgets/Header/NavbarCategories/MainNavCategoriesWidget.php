<?php


namespace shop\widgets\Header\NavbarCategories;



use core\entities\Shop\Product\Category;
use core\readModels\Shop\CategoryReadRepository;
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
            foreach ($categories as $category) {
                $active = $this->active && ($this->active->id == $category->id || $this->active->isChildOf($category));

                if ($category->depth == $depth) {
                    if (!$category->children) {
                        echo Html::a(
                            Html::encode($category->name),
                            ['/shop/catalog/category', 'id' => $category->id],
                            ['class' => $active ? 'nav-item nav-link active' : 'nav-item nav-link']
                        );
                    }

                    if ($category->children) {
                        echo Html::beginTag('div', ['class' => 'nav-item dropdown']);
                        echo Html::a(
                            Html::encode($category->name) . "<i class='fa fa-angle-down float-right mt-1'></i>",
                            ['/shop/catalog/category', 'id' => $category->id],
                            [
                                'class' =>$active ? 'nav-link active' : 'nav-link',
                                'data-toggle' => 'dropdown'
                            ]
                        );
                        echo Html::beginTag(
                            'div',
                            ['class' => 'dropdown-menu position-absolute bg-secondary border-0 rounded-0 w-100 m-0']
                        );

                        //if (!$category->children) { Uncomment if you do not want to display the main category
                            echo Html::a(
                                Html::encode($category->name),
                                ['/shop/catalog/category', 'id' => $category->id],
                                ['class' =>$active ? 'dropdown-item active' : 'dropdown-item']
                            );
                       //}  Uncomment if you do not want to display the main category
                            $this->printNode($category->children, ++$category->depth);
                        echo Html::endTag('div');
                        echo Html::endTag('div');
                    }
                }
            }
        }
    }

    public function run()
    {
        $this->printNode($this->categories->getTreeForMainMenu());
    }

}


